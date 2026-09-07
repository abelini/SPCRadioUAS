<?php

declare(strict_types=1);

namespace SPC\Controller\Admin;

use SPC\Controller\AppController;
use SPC\DTO\ProgrammeItem;
use SPC\DTO\StreamData;
use SPC\Enum\PTY;
use SPC\Model\Entity\Programa;
use SPC\Trait\APICacheTrait;
use Cake\Cache\Cache;
use Cake\Collection\Collection;
use Cake\Core\Configure;
use Cake\Http\Response;
use Cake\I18n\DateTime;
use Cake\ORM\Query\SelectQuery;
use IntlDateFormatter;


class ScheduleController extends AppController
{
    use APICacheTrait;

    public function index(): void
    {
        if ($this->request->getQuery('cancel') !== null) {
            Cache::delete(self::SCHEDULE_CACHE_KEY, self::SCHEDULE_CACHE_CONFIG);
            $this->Flash->success('La programación habitual volvió a la normalidad.');
            $this->redirect(['action' => 'index']);
            return;
        }

        $dias = $this->getTableLocator()->get('Dias')->find()->all();
        $dayNames = [];
        foreach ($dias as $d) {
            $dayNames[(int) $d->ID] = $d->name;
        }

        $activeDay = (int) $this->request->getQuery('day');
        if ($activeDay < 1 || $activeDay > 7) {
            $activeDay = self::getDateNow()->dayOfWeek;
        }

        $programas = $this->getTableLocator()
            ->get('Programas')
            ->find('allForDay', day: $activeDay)
            ->all();

        $items = $this->buildDayItems($programas);
        $overrideActive = $this->isOverrideActive();

        $this->set(compact('dayNames', 'activeDay', 'items', 'overrideActive'));
        $this->render();
    }

    private function buildDayItems(iterable $programas): Collection
    {
        $items = [];
        $prev = null;
        foreach ($programas as $p) {
            if ($prev !== null) {
                $prevEnd = $prev->horaFin->getHours() * 60 + $prev->horaFin->getMinutes();
                $curStart = $p->horaInicio->getHours() * 60 + $p->horaInicio->getMinutes();
                if ($curStart > $prevEnd) {
                    $items[] = new ProgrammeItem(
                        ID: 999,
                        horaInicio: $prev->horaFin,
                        horaFin: $p->horaInicio,
                        name: Programa::getDefaultName(),
                        produccion: Programa::getDefaultProduction(),
                        image: Programa::getDefaultCover(musical: true),
                        icon: Programa::getDefaultIcon(musical: true),
                    );
                }
            }
            $items[] = new ProgrammeItem(
                ID: $p->ID,
                horaInicio: $p->horaInicio,
                horaFin: $p->horaFin,
                name: $p->name,
                produccion: $p->produccion,
                image: $p->image_url,
                icon: $p->categoria->icon,
            );
            $prev = $p;
        }

        return new Collection($items);
    }

    public function override(): Response
    {
        if ($this->request->getQuery('cancel') !== null) {
            Cache::delete(self::SCHEDULE_CACHE_KEY, self::SCHEDULE_CACHE_CONFIG);
            $this->Flash->success('La programación habitual volvió a la normalidad.');

            return $this->redirect(['action' => 'override']);
        }

        $timezone = Configure::read('App.defaultTimezone');
        $intlFormat = IntlDateFormatter::LONG;

        $now = DateTime::now();
        $midnight = $now->endOfDay();

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $untilMidnight = !empty($data['until_midnight']);

            if ($untilMidnight) {
                $durationMinutes = $now->diffInMinutes($midnight);
                $expiresAt = $midnight->getTimestamp();
            } else {
                $durationMinutes = (int) $data['duration_minutes'];
                $expiresAt = $now->addMinutes($durationMinutes)->getTimestamp();
            }

            Cache::write(self::SCHEDULE_CACHE_KEY, [
                'programa' => $data['programa'],
                'produccion' => $data['produccion'],
                'conduccion' => $data['conduccion'],
                'music' => (bool) $data['music'],
                'pty' => (int) $data['pty'],
                'ptn' => $data['ptn'],
                'hora_inicio' => $now->getTimestamp(),
                'duration_minutes' => $durationMinutes,
                'expires_at' => $expiresAt,
            ], self::SCHEDULE_CACHE_CONFIG);

            $this->Flash->success('Se ha sobreescrito la programación habitual hasta el ' . DateTime::createFromTimestamp($expiresAt)->i18nFormat(IntlDateFormatter::FULL, $timezone) . '.');

            return $this->redirect(['action' => 'override']);
        }

        $override = Cache::read(self::SCHEDULE_CACHE_KEY, self::SCHEDULE_CACHE_CONFIG);
        if ($override !== null && $override['expires_at'] < time()) {
            Cache::delete(self::SCHEDULE_CACHE_KEY, self::SCHEDULE_CACHE_CONFIG);
            $override = null;
        }

        $minutesUntilMidnight = $now->diffInMinutes($midnight);
        $defaultPrograma = StreamData::DEFAULT_PROGRAM_NAME;
        $defaultProduccion = StreamData::DEFAULT_PRODUCTION_NAME;
        $defaultConduccion = StreamData::DEFAULT_CONDUCCION;
        $defaultMusic = StreamData::DEFAULT_MUSICAL;
        $defaultDurationMinutes = StreamData::DEFAULT_DURATION_MINUTES;
        $defaultPty = StreamData::DEFAULT_PTY;
        $defaultPtn = StreamData::DEFAULT_PTN;

        $programTypes = array_column(PTY::cases(), 'name');

        $this->set(compact(
            'override',
            'minutesUntilMidnight',
            'defaultPrograma',
            'defaultProduccion',
            'defaultConduccion',
            'defaultMusic',
            'defaultDurationMinutes',
            'defaultPty',
            'defaultPtn',
            'programTypes',
            'timezone',
            'intlFormat',
        ));

        return $this->render();
    }
}
