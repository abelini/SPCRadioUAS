<?php
declare(strict_types=1);

namespace SPC\Service;

use Cake\ORM\TableRegistry;
use Cake\ORM\Query\SelectQuery;

/**
 * Construye el documento XML de programación electrónica de guía (EPG)
 * siguiendo el esquema RadioDNS EPG v10, compatible con onlineradiobox.com.
 */
class EpgBuilder
{
    private const string XML_VERSION = '1.0';
    private const string XML_ENCODING = 'utf-8';
    private const string NS_RADIODNS = 'https://schemas.radiodns.org/epg/10';
    private const string NS_EPG_DATA = 'https://www.worlddab.org/schemas/epgDataTypes/14';
    private const string NS_EPG_SCHEDULE = 'https://www.worlddab.org/schemas/epgSchedule/14';
    private const string XML_LANG = 'es';
    private const string STATION_URL = 'https://radio.uas.edu.mx';
    private const string STATION_CRID = 'crid://radio.uas.edu.mx/';
    private const string TIMEZONE = 'America/Mazatlan';
    private const int MAX_SHORT_NAME_LENGTH = 8;

    /** Mapeo del dayOfWeek de la app (1=lunes … 7=domingo) a abreviaturas RFC */
    private const array DAY_ABBREVIATIONS = [
        1 => 'MO',
        2 => 'TU',
        3 => 'WE',
        4 => 'TH',
        5 => 'FR',
        6 => 'SA',
        7 => 'SU',
    ];

    /**
     * Genera el XML EPG completo con todos los programas de la semana,
     * en un único <r:service> con su <s:schedule> y los <s:programmeGroup>.
     */
    public function build(): string
    {
        $programmes = $this->fetchAllProgrammes();

        $dom = new \DOMDocument(self::XML_VERSION, self::XML_ENCODING);
        $dom->formatOutput = true;

        // Raíz <radio> con los tres namespaces
        $radio = $dom->createElement('radio');
        $radio->setAttribute('xmlns:r', self::NS_RADIODNS);
        $radio->setAttribute('xmlns:e', self::NS_EPG_DATA);
        $radio->setAttribute('xmlns:s', self::NS_EPG_SCHEDULE);
        $dom->appendChild($radio);

        // <r:service>
        $service = $dom->createElement('r:service');
        $service->setAttribute('id', self::STATION_CRID);
        $service->setAttribute('xml:lang', self::XML_LANG);
        $radio->appendChild($service);

        // <e:link> hacia la URL de la emisora
        $link = $dom->createElement('e:link');
        $link->setAttribute('url', self::STATION_URL);
        $link->setAttribute('description', 'Escuchar en vivo');
        $service->appendChild($link);

        // <s:schedule> con una entrada <s:programme> por cada ocurrencia (programa + día)
        $schedule = $dom->createElement('s:schedule');
        $service->appendChild($schedule);

        foreach ($programmes as $programme) {
            foreach ($programme['days'] as $dayOfWeek) {
                $prog = $dom->createElement('s:programme');

                $memberOf = $dom->createElement('e:memberOf');
                $memberOf->setAttribute('id', $this->programCrid($programme['ID']));
                $prog->appendChild($memberOf);

                $time = $dom->createElement('s:time');
                $time->setAttribute('time', $programme['startTime']);
                $time->setAttribute('duration', $programme['duration']);
                $time->setAttribute('recurs', self::DAY_ABBREVIATIONS[$dayOfWeek]);
                $prog->appendChild($time);

                $schedule->appendChild($prog);
            }
        }

        // <s:programmeGroup> por cada programa único (metadatos)
        foreach ($programmes as $programme) {
            $radio->appendChild(
                $this->buildProgrammeGroup($dom, $programme)
            );
        }

        return (string) $dom->saveXML();
    }

    /**
     * Construye el nodo <s:programmeGroup> con los metadatos de un programa.
     */
    private function buildProgrammeGroup(\DOMDocument $dom, array $programme): \DOMElement
    {
        $group = $dom->createElement('s:programmeGroup');
        $group->setAttribute('xml:lang', self::XML_LANG);
        $group->setAttribute('id', $this->programCrid($programme['ID']));

        $shortName = $dom->createElement(
            'e:shortName',
            htmlspecialchars($this->truncate($programme['name'], self::MAX_SHORT_NAME_LENGTH), ENT_XML1)
        );
        $group->appendChild($shortName);

        $longName = $dom->createElement(
            'e:longName',
            htmlspecialchars($programme['name'], ENT_XML1)
        );
        $group->appendChild($longName);

        $presenter = $dom->createElement('presenter');
        if (!empty($programme['conduccion'])) {
            $presenter->nodeValue = htmlspecialchars($programme['conduccion'], ENT_XML1);
        }
        $group->appendChild($presenter);

        if (!empty($programme['produccion'])) {
            $longDesc = $dom->createElement(
                'e:longDescription',
                htmlspecialchars($programme['produccion'], ENT_XML1)
            );
            $group->appendChild($longDesc);
        }

        $link = $dom->createElement('e:link');
        $link->setAttribute('description', 'Programación Radio UAS');
        $link->setAttribute('url', self::STATION_URL . '/programacion');
        $group->appendChild($link);

        return $group;
    }

    /**
     * Consulta todos los programas activos con sus días de transmisión.
     * Devuelve un array asociativo listo para renderizar en el XML.
     */
    private function fetchAllProgrammes(): array
    {
        /** @var \SPC\Model\Table\ProgramasTable $table */
        $table = TableRegistry::getTableLocator()->get('Programas');

        $results = $table->find()
            ->select([
                'Programas.ID',
                'Programas.name',
                'Programas.horaInicio',
                'Programas.horaFin',
                'Programas.produccion',
                'Programas.conduccion',
            ])
            ->contain('Dias', function (SelectQuery $q) {
                return $q->select(['Dias.ID']);
            })
            ->orderByAsc('Programas.horaInicio')
            ->all();

        $programmes = [];

        foreach ($results as $programme) {
            $startDt = new \DateTimeImmutable(
                'today ' . $programme->horaInicio->format('H:i:s'),
                new \DateTimeZone(self::TIMEZONE)
            );
            $stopDt = new \DateTimeImmutable(
                'today ' . $programme->horaFin->format('H:i:s'),
                new \DateTimeZone(self::TIMEZONE)
            );

            // Programa que cruza medianoche (ej. 23:00 – 01:00)
            if ($stopDt <= $startDt) {
                $stopDt = $stopDt->modify('+1 day');
            }

            $programmes[] = [
                'ID' => $programme->ID,
                'name' => $programme->name,
                'produccion' => $programme->produccion,
                'conduccion' => $programme->conduccion,
                'startTime' => 'T' . $programme->horaInicio->format('H:i:s'),
                'duration' => $this->isoDuration($startDt, $stopDt),
                'days' => array_map(fn($d) => $d->ID, $programme->dias),
            ];
        }

        return $programmes;
    }

    /**
     * Genera el CRID único para un programa dado su ID.
     */
    private function programCrid(int $programmeId): string
    {
        return self::STATION_CRID . 'schedule/?id=' . $programmeId;
    }

    /**
     * Genera una duración en formato ISO 8601 (PTxHxxM) a partir de dos instantes.
     */
    private function isoDuration(\DateTimeImmutable $start, \DateTimeImmutable $stop): string
    {
        $seconds = $stop->getTimestamp() - $start->getTimestamp();
        $hours = intdiv($seconds, 3600);
        $minutes = intdiv($seconds % 3600, 60);

        return sprintf('PT%dH%02dM', $hours, $minutes);
    }

    /**
     * Trunca un string a un máximo de caracteres.
     */
    private function truncate(string $text, int $maxLength): string
    {
        if (mb_strlen($text) <= $maxLength) {
            return $text;
        }
        return mb_substr($text, 0, $maxLength);
    }
}