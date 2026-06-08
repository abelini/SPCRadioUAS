<?php
declare(strict_types=1);

namespace SPC\Service;

use Cake\Core\Configure;
use Cake\I18n\DateTime;
use Cake\ORM\TableRegistry;
use Cake\ORM\Query\SelectQuery;
use Cake\View\View;
use DOMDocument;
use InvalidArgumentException;

/**
 * Construye el documento XML de programación electrónica de guía (EPG)
 * siguiendo el esquema RadioDNS EPG v10, compatible con onlineradiobox.com.
 */
class EpgBuilder
{
    private const string XML_VERSION = '1.0';
    private const string XML_ENCODING = 'utf-8';

    private const string SHORT_NAME = 'RadioUAS';
    private const string MEDIUM_NAME = 'Radio UAS';
    private const string LONG_NAME = 'Radio UAS 96.1 FM';

    private const string BEARER_URI = 'fm:ae4.a961.09610';
    private const string SI_VERSION = '3.5';
    private const string RADIODNS_FQDN = 'spc.radiouas.org';
    private const string RADIODNS_SID = 'radiouas';

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
     * Genera el XML de Servicio (Service Information) según el estándar
     * RadioDNS SPI 3.5 con los datos fijos de la estación.
     */
    public function buildSI(): string
    {
        $dom = new DOMDocument(self::XML_VERSION, self::XML_ENCODING);
        $dom->formatOutput = true;

        // 1. CREACIÓN DEL ELEMENTO RAÍZ CON EL NAMESPACE DE WORLDDAB
        $nsWorldDab = 'http://www.worlddab.org/schemas/spi';
        $serviceInfo = $dom->createElementNS($nsWorldDab, 'serviceInformation');
        
        // Atributo: xmlns:xsi
        $serviceInfo->setAttributeNS(
            'http://www.w3.org/2000/xmlns/',
            'xmlns:xsi',
            'http://www.w3.org/2001/XMLSchema-instance'
        );
        
        // Atributo: xmlns:xml (Exigido en tu ejemplo)
        $serviceInfo->setAttributeNS(
            'http://www.w3.org/2000/xmlns/',
            'xmlns:xml',
            'http://www.w3.org/XML/1998/namespace'
        );
        
        // Atributo: xsi:schemaLocation (Apuntando a spi_34.xsd como tu ejemplo)
        $serviceInfo->setAttributeNS(
            'http://www.w3.org/2001/XMLSchema-instance',
            'xsi:schemaLocation',
            'http://www.worlddab.org/schemas/spi http://www.worlddab.org/schemas/spi/spi_34.xsd'
        );

        // 2. ATRIBUTOS DIRECTOS EN LA RAÍZ (Igual que tu ejemplo)
        $serviceInfo->setAttribute('creationTime', DateTime::now('UTC')->format('Y-m-d\TH:i:s\Z'));
        $serviceInfo->setAttribute('originator', self::MEDIUM_NAME); // Ej: "Radio UAS"
        $serviceInfo->setAttribute('xml:lang', self::XML_LANG);
        
        $dom->appendChild($serviceInfo);

        $services = $dom->createElement('services');
        $serviceInfo->appendChild($services);

        $service = $dom->createElement('service');
        $services->appendChild($service);

        $shortName = $dom->createElement('shortName', self::SHORT_NAME);
        $service->appendChild($shortName);

        $mediumName = $dom->createElement('mediumName', self::MEDIUM_NAME);
        $service->appendChild($mediumName);

        $longName = $dom->createElement('longName', self::LONG_NAME);
        $service->appendChild($longName);

        $mediaDescription = $dom->createElement('mediaDescription');
        $service->appendChild($mediaDescription);

        $multimedia = $dom->createElement('multimedia');
        $multimedia->setAttribute('url', (new View())->Url->build('/img/logo_600x600.png', ['fullBase' => true]));
        $multimedia->setAttribute('type', 'logo_color_square');
        $multimedia->setAttribute('width', '600');
        $multimedia->setAttribute('height', '600');
        $mediaDescription->appendChild($multimedia);

        $link = $dom->createElement('link');
        $scheduleUrl = (new View())->Url->build('/api/schedule/epg', ['fullBase' => true]);
        $link->setAttribute('uri', $scheduleUrl);
        $link->setAttribute('mimeValue', 'application/xml+pi');
        $service->appendChild($link);

        $linkWeb = $dom->createElement('link');
        $linkWeb->setAttribute('uri', 'https://radio.uas.edu.mx');
        $linkWeb->setAttribute('mimeValue', 'text/html');
        $service->appendChild($linkWeb);

        $bearer = $dom->createElement('bearer');
        $bearer->setAttribute('id', self::BEARER_URI);
        $bearer->setAttribute('cost', '0');
        $service->appendChild($bearer);

        $bearerStream = $dom->createElement('bearer');
        $bearerStream->setAttribute('id', Configure::read('MP3StreamURI'));
        $bearerStream->setAttribute('mimeValue', 'audio/mpeg');
        $bearerStream->setAttribute('bitrate', '64');
        $bearerStream->setAttribute('cost', '10');
        $service->appendChild($bearerStream);

        $radiodns = $dom->createElement('radiodns');
        $radiodns->setAttribute('fqdn', self::RADIODNS_FQDN);
        $radiodns->setAttribute('serviceIdentifier', self::RADIODNS_SID);
        $service->appendChild($radiodns);

        return (string) $dom->saveXML();
    }


    public function buildEpgSchedule(): string
    {
        $programmes = $this->fetchAllProgrammes();

        $dom = new DOMDocument(self::XML_VERSION, self::XML_ENCODING);
        $dom->formatOutput = true;

        $epg = $dom->createElementNS('http://www.radiodns.org/spi/3.5', 'epg');
        $epg->setAttributeNS(
            'http://www.w3.org/2000/xmlns/',
            'xmlns:xsi',
            'http://www.w3.org/2001/XMLSchema-instance'
        );
        $epg->setAttributeNS(
            'http://www.w3.org/2001/XMLSchema-instance',
            'xsi:schemaLocation',
            'http://www.radiodns.org/spi/3.5 http://www.radiodns.org/spi/3.5/spi_3.5.xsd'
        );
        $epg->setAttribute('xml:lang', self::XML_LANG);
        $dom->appendChild($epg);

        $now = DateTime::now(self::TIMEZONE);
        $todayStart = $now->startOfDay();
        $tomorrowEnd = $todayStart->addDays(2)->subSeconds(1);
        $today = $now->startOfDay();
        $tomorrow = $today->addDays(1);

        $schedule = $dom->createElement('schedule');
        $schedule->setAttribute('creationTime', $now->setTimezone('UTC')->format('Y-m-d\TH:i:s\Z'));
        $schedule->setAttribute('originator', self::MEDIUM_NAME);
        $schedule->setAttribute('version', '1');
        $epg->appendChild($schedule);

        $scope = $dom->createElement('scope');
        $scope->setAttribute('startTime', $todayStart->setTimezone('UTC')->format('Y-m-d\TH:i:s\Z'));
        $scope->setAttribute('stopTime', $tomorrowEnd->setTimezone('UTC')->format('Y-m-d\TH:i:s\Z'));
        $schedule->appendChild($scope);

        $serviceScope = $dom->createElement('serviceScope');
        $serviceScope->setAttribute('id', self::BEARER_URI);
        $scope->appendChild($serviceScope);

        $tzMaz = new \DateTimeZone(self::TIMEZONE);
        $tzUtc = new \DateTimeZone('UTC');

        $entries = [];
        foreach ($programmes as $programme) {
            $timeStr = substr($programme['startTime'], 1);

            foreach ([$today, $tomorrow] as $dayDate) {
                $local = new \DateTime(
                    $dayDate->format('Y-m-d') . ' ' . $timeStr,
                    $tzMaz
                );
                $local->setTimezone($tzUtc);
                $entries[] = [
                    'startUtc' => $local,
                    'programme' => $programme,
                    'dayDate' => $dayDate,
                ];
            }
        }

        usort($entries, fn(array $a, array $b): int => $a['startUtc'] <=> $b['startUtc']);

        foreach ($entries as $entry) {
            $p = $entry['programme'];
            $startUtc = $entry['startUtc'];
            $dayDate = $entry['dayDate'];

            $progEl = $dom->createElement('programme');
            $progEl->setAttribute('shortId', (string) $p['ID']);
            $progEl->setAttribute('id', self::STATION_CRID . 'schedule/' . $p['ID'] . '/' . $dayDate->format('Y-m-d'));
            $progEl->setAttribute('version', '1');
            $progEl->setAttribute('recommendation', 'no');
            $progEl->setAttribute('broadcast', 'on-air');

            $mediumName = $dom->createElement(
                'mediumName',
                htmlspecialchars($p['name'], ENT_XML1)
            );
            $mediumName->setAttribute('xml:lang', self::XML_LANG);
            $progEl->appendChild($mediumName);

            $descParts = [];
            if (!empty($p['conduccion'])) {
                $descParts[] = 'Conducción: ' . $p['conduccion'];
            }
            if (!empty($p['produccion'])) {
                $descParts[] = $p['produccion'];
            }
            if ($descParts !== []) {
                $mediaDesc = $dom->createElement('mediaDescription');
                $shortDesc = $dom->createElement(
                    'shortDescription',
                    htmlspecialchars(mb_substr(implode('. ', $descParts), 0, 180), ENT_XML1)
                );
                $shortDesc->setAttribute('xml:lang', self::XML_LANG);
                $mediaDesc->appendChild($shortDesc);
                $progEl->appendChild($mediaDesc);
            }

            $location = $dom->createElement('location');
            $timeInfo = $dom->createElement('timeInformation');
            $timeInfo->setAttribute('start', $startUtc->format('Y-m-d\TH:i:s\Z'));
            $timeInfo->setAttribute('duration', $p['duration']);
            $location->appendChild($timeInfo);
            $progEl->appendChild($location);

            $schedule->appendChild($progEl);
        }

        return (string) $dom->saveXML();
    }

    /**
     * Genera el XML de Programme Information (PI) para una fecha específica,
     * en formato RadioDNS SPI 3.5, con los programas que se transmiten ese día.
     */
    public function buildPI(DateTime $date): string
    {
        $programmes = $this->fetchAllProgrammes();
        $dayOfWeek = $date->dayOfWeek;

        $dom = new DOMDocument(self::XML_VERSION, self::XML_ENCODING);
        $dom->formatOutput = true;

        $epg = $dom->createElementNS('http://www.worlddab.org/schemas/spi', 'epg');
        
        $epg->setAttributeNS(
            'http://www.w3.org/2000/xmlns/',
            'xmlns:xsi',
            'http://www.w3.org/2001/XMLSchema-instance'
        );
        
        $epg->setAttributeNS(
            'http://www.w3.org/2000/xmlns/',
            'xmlns:xml',
            'http://www.w3.org/XML/1998/namespace'
        );
        
        $epg->setAttributeNS(
            'http://www.w3.org/2001/XMLSchema-instance',
            'xsi:schemaLocation',
            'http://www.worlddab.org/schemas/spi http://www.worlddab.org/schemas/spi/spi_34.xsd'
        );
        $epg->setAttribute('xml:lang', self::XML_LANG);
        $dom->appendChild($epg);

        $dayStart = $date->startOfDay();
        $dayEnd = $date->endOfDay();

        $schedule = $dom->createElement('schedule');
        $schedule->setAttribute('creationTime', DateTime::now()->toIso8601String());
        $schedule->setAttribute('originator', self::MEDIUM_NAME);
        $schedule->setAttribute('version', '1');
        $epg->appendChild($schedule);

        $scope = $dom->createElement('scope');
        $scope->setAttribute('startTime', $dayStart->toIso8601String());
        $scope->setAttribute('stopTime', $dayEnd->toIso8601String());
        $schedule->appendChild($scope);

        $serviceScope = $dom->createElement('serviceScope');
        $serviceScope->setAttribute('id', self::BEARER_URI);
        $scope->appendChild($serviceScope);

        $entries = [];
        foreach ($programmes as $programme) {
            if (!in_array($dayOfWeek, $programme['days'], true)) {
                continue;
            }

            $timeStr = substr($programme['startTime'], 1);
            $local = DateTime::now()->setTimeFromTimeString($timeStr);

            $entries[] = [
                'startUtc' => $local,
                'programme' => $programme,
            ];
        }

        usort($entries, fn(array $a, array $b): int => $a['startUtc'] <=> $b['startUtc']);

        foreach ($entries as $entry) {
            $p = $entry['programme'];
            $startUtc = $entry['startUtc'];

            $progEl = $dom->createElement('programme');
            $progEl->setAttribute('shortId', (string) $p['ID']);
            $progEl->setAttribute('id', self::STATION_CRID . 'schedule/' . $p['ID'] . '/' . $date->format('Y-m-d'));
            $progEl->setAttribute('version', '1');
            $progEl->setAttribute('recommendation', 'no');
            $progEl->setAttribute('broadcast', 'on-air');

            $mediumName = $dom->createElement(
                'mediumName',
                htmlspecialchars($p['name'], ENT_XML1)
            );
            $mediumName->setAttribute('xml:lang', self::XML_LANG);
            $progEl->appendChild($mediumName);

            $descParts = [];
            if (!empty($p['conduccion'])) {
                $descParts[] = 'Conducción: ' . $p['conduccion'];
            }
            if (!empty($p['produccion'])) {
                $descParts[] = $p['produccion'];
            }
            if ($descParts !== []) {
                $mediaDesc = $dom->createElement('mediaDescription');
                $shortDesc = $dom->createElement(
                    'shortDescription',
                    htmlspecialchars(mb_substr(implode('. ', $descParts), 0, 180), ENT_XML1)
                );
                $shortDesc->setAttribute('xml:lang', self::XML_LANG);
                $mediaDesc->appendChild($shortDesc);
                $progEl->appendChild($mediaDesc);
            }

            $location = $dom->createElement('location');
            $timeInfo = $dom->createElement('timeInformation');
            $timeInfo->setAttribute('start', $startUtc->toIso8601String());
            $timeInfo->setAttribute('duration', $p['duration']);
            $location->appendChild($timeInfo);
            $progEl->appendChild($location);

            $schedule->appendChild($progEl);
        }

        return (string) $dom->saveXML();
    }

    /**
     * Genera el XML EPG completo con todos los programas de la semana,
     * en un único <r:service> con su <s:schedule> y los <s:programmeGroup>.
     */
    public function buildEpg(): string
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