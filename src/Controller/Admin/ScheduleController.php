<?php

declare(strict_types=1);

namespace SPC\Controller\Admin;

use SPC\Controller\AppController;
use SPC\DTO\StreamData;
use SPC\Enum\PTY;
use SPC\Trait\APICacheTrait;
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Http\Response;
use Cake\I18n\DateTime;
use IntlDateFormatter;


class ScheduleController extends AppController
{
    use APICacheTrait;

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
