<?php
declare(strict_types=1);

namespace SPC\Controller\Admin;

use Cake\Cache\Cache;
use Cake\Http\Response;
use SPC\Controller\AppController;
use Cake\I18n\DateTime;

class ScheduleController extends AppController
{
    private const string SCHEDULE_CACHE_KEY = 'schedule_override';

    private const string SCHEDULE_CACHE_CONFIG = 'programas_api';
    private const string DEFAULT_PROGRAMA = 'Programa Especial';
    private const string DEFAULT_PRODUCCION = 'Producción Especial';
    private const string DEFAULT_CONDUCCION = '';
    private const bool DEFAULT_MUSIC = false;
    private const string DEFAULT_HORA_INICIO = '00:00';
    private const int DEFAULT_DURATION_MINUTES = 60;

    public function override(): Response
    {
        if ($this->request->getQuery('cancel') !== null) {
            Cache::delete(self::SCHEDULE_CACHE_KEY, self::SCHEDULE_CACHE_CONFIG);
            $this->Flash->success('Override de schedule cancelado.');

            return $this->redirect(['action' => 'override']);
        }

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $untilMidnight = !empty($data['until_midnight']);

            if ($untilMidnight) {
                $midnight = (new DateTime())->setTime(23, 59, 59);
                $now = DateTime::now();
                $durationMinutes = (int) (($midnight->getTimestamp() - $now->getTimestamp()) / 60);
                $expiresAt = $midnight->getTimestamp();
            } else {
                $durationMinutes = (int) ($data['duration_minutes'] ?? self::DEFAULT_DURATION_MINUTES);
                $expiresAt = time() + ($durationMinutes * 60);
            }

            Cache::write(self::SCHEDULE_CACHE_KEY, [
                'programa' => $data['programa'] ?? self::DEFAULT_PROGRAMA,
                'produccion' => $data['produccion'] ?? self::DEFAULT_PRODUCCION,
                'conduccion' => $data['conduccion'] ?? self::DEFAULT_CONDUCCION,
                'music' => !empty($data['music']),
                'hora_inicio' => $data['hora_inicio'] ?? self::DEFAULT_HORA_INICIO,
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

        $now = DateTime::now();
        $midnight = $now->setTime(23, 59, 59);
        $minutesUntilMidnight = (int) (($midnight->getTimestamp() - $now->getTimestamp()) / 60);

        $defaultPrograma = self::DEFAULT_PROGRAMA;
        $defaultProduccion = self::DEFAULT_PRODUCCION;
        $defaultConduccion = self::DEFAULT_CONDUCCION;
        $defaultMusic = self::DEFAULT_MUSIC;
        $defaultHoraInicio = self::DEFAULT_HORA_INICIO;
        $defaultDurationMinutes = self::DEFAULT_DURATION_MINUTES;

        $this->set(compact(
            'override',
            'minutesUntilMidnight',
            'defaultPrograma',
            'defaultProduccion',
            'defaultConduccion',
            'defaultMusic',
            'defaultHoraInicio',
            'defaultDurationMinutes',
        ));

        return $this->render();
    }
}