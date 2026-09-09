<?php

declare(strict_types=1);

namespace SPC\Controller\Admin;

use SPC\Controller\AppController;
use SPC\DTO\RadioProgram;
use SPC\DTO\StreamData;
use SPC\Enum\PTY;
use SPC\Model\Entity\Programa;
use SPC\Trait\APICacheTrait;
use Cake\Cache\Cache;
use Cake\Collection\Collection;
use Cake\Core\Configure;
use Cake\Http\Response;
use Cake\I18n\DateTime;
use Cake\I18n\Time;
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
    /*
    public function __construct(
        public readonly int $ID,
        public readonly string $name,
        public readonly string $producer,
        public readonly string $host,
        public readonly string $slug,
        public readonly string $image,
        public readonly string $icon,
        public readonly Time $startTime,
        public readonly Time $endTime,
    ) {}
        */
    private function buildDayItems(iterable $programas): Collection
    {
        $items = [];
        $prev = null;
        foreach ($programas as $p) {
            if ($prev !== null) {
                $prevEnd = $prev->horaFin->getHours() * 60 + $prev->horaFin->getMinutes();
                $curStart = $p->horaInicio->getHours() * 60 + $p->horaInicio->getMinutes();
                if ($curStart > $prevEnd) {
                    // PAISAJES SONOROS
                    $items[] = new RadioProgram(
                        ID: 999,
                        startTime: $prev->horaFin,
                        endTime: $p->horaInicio,
                        name: Programa::getDefaultName(),
                        producer: Programa::getDefaultProduction(),
                        host: $p->host,
                        image: Programa::getDefaultCover(musical: true),
                        icon: Programa::getDefaultIcon(musical: true),
                        slug: 'music',
                    );
                }
            }
            $items[] = new RadioProgram(
                ID: $p->ID,
                name: $p->name,
                producer: $p->produccion,
                host: $p->conduccion,
                slug: $p->categoria->slug,
                image: $p->image_url,
                startTime: $p->horaInicio,
                endTime: $p->horaFin,
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
                'hora_inicio' => Time::now() /*$now->getTimestamp()*/,
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
        $defaultPrograma = StreamData::DEFAULT_NAME;
        $defaultProduccion = StreamData::DEFAULT_PRODUCER;
        $defaultConduccion = StreamData::DEFAULT_HOST;
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
