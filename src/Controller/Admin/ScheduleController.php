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
    /*
    private const string CACHE_CONFIG = 'programas_api';

    private const string CACHE_KEY = 'schedule_override';

    private const string DEFAULT_PROGRAMA = 'Paisajes sonoros';

    private const string DEFAULT_PRODUCCION = 'Fonoteca';

    private const string DEFAULT_CONDUCCION = 'Auto DJ';

    private const bool DEFAULT_MUSIC = true;

    private const string DEFAULT_HORA_INICIO = '00:00';

    private const int DEFAULT_DURATION_MINUTES = 60;

    private const int DEFAULT_PTY = 12;

    private const string DEFAULT_PTN = 'Musica';
    */

    use APICacheTrait;

    public function override(): Response
    {
        if ($this->request->getQuery('cancel') !== null) {
            Cache::delete(self::SCHEDULE_CACHE_KEY, self::SCHEDULE_CACHE_CONFIG);
            $this->Flash->success('Override de schedule cancelado.');

            return $this->redirect(['action' => 'override']);
        }

        $midnight = (new DateTime())->setTime(23, 59, 59);

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $untilMidnight = !empty($data['until_midnight']);

            if ($untilMidnight) {
                $durationMinutes = parent::$datetime->diffInMinutes($midnight);
                $expiresAt = $midnight->getTimestamp();
            } else {
                $durationMinutes = (int) $data['duration_minutes'];
                $expiresAt = parent::$datetime->getTimestamp() + ($durationMinutes * 60);
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

        $minutesUntilMidnight = parent::$datetime->diffInMinutes($midnight);
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
