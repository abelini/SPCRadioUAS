<?php
declare(strict_types=1);

namespace SPC\Controller\Admin;

use Cake\Cache\Cache;
use Cake\Http\Response;
use SPC\Controller\AppController;
use Cake\I18n\DateTime;
use SPC\Trait\APICacheTrait;
use SPC\DTO\StreamData;

class ScheduleController extends AppController
{
    use APICacheTrait;

    public function override(): Response
    {
        if ($this->request->getQuery('cancel') !== null) {
            Cache::delete(self::SCHEDULE_CACHE_KEY, self::SCHEDULE_CACHE_CONFIG);
            $this->Flash->success('Override de schedule cancelado.');

            return $this->redirect(['action' => 'override']);
        }

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
                'music' => !empty($data['music']),
                'pty' => (int) $data['pty'],
                'ptn' => $data['ptn'],
                'hora_inicio' => $data['hora_inicio'],
                'duration_minutes' => $durationMinutes,
                'expires_at' => $expiresAt,
            ], self::SCHEDULE_CACHE_CONFIG);

            $this->Flash->success('Override de schedule aplicado.');

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
        $defaultHoraInicio = StreamData::DEFAULT_HORA_INICIO;
        $defaultDurationMinutes = StreamData::DEFAULT_DURATION_MINUTES;
        $defaultPty = StreamData::DEFAULT_PTY;
        $defaultPtn = StreamData::DEFAULT_PTN;

        $this->set(compact(
            'override',
            'minutesUntilMidnight',
            'defaultPrograma',
            'defaultProduccion',
            'defaultConduccion',
            'defaultMusic',
            'defaultHoraInicio',
            'defaultDurationMinutes',
            'defaultPty',
            'defaultPtn',
        ));

        return $this->render();
    }
}
