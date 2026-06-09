<?php
declare(strict_types=1);

namespace SPC\Service;

use Cake\Cache\Cache;
use Cake\I18n\DateTime;
use Cake\I18n\Time;
use Cake\ORM\Query\SelectQuery;
use Cake\ORM\TableRegistry;

class NowPlayingService
{
    public const string CONTROL_REMOTO_CACHE = 'active_remote_broadcast';

    public const int MAX_REMOTE_CONTROL_TIME = 7200;

    public const string DEFAULT_PROGRAM_NAME = 'Paisajes sonoros';

    public const string DEFAULT_PRODUCTION_NAME = 'Fonoteca';

    public function get(): array
    {
        $rc = Cache::read(self::CONTROL_REMOTO_CACHE);
        if ($rc) {
            if (time() - $rc['inicio'] <= self::MAX_REMOTE_CONTROL_TIME) {
                return [
                    'programa' => $rc['evento'],
                    'produccion' => $rc['produccion'],
                ];
            }
            Cache::delete(self::CONTROL_REMOTO_CACHE);
        }

        $programas = TableRegistry::getTableLocator()
            ->get('Programas')
            ->find()
            ->matching('Dias', function (SelectQuery $query) {
                return $query->where(['Dias.ID' => new DateTime()->dayOfWeek]);
            })
            ->orderByAsc('horaInicio')
            ->all();

        $nowPlaying = $programas->filter(function ($programa) {
            $now = Time::now();
            if ($programa->horaFin->lessThan($programa->horaInicio)) {
                return $now->greaterThanOrEquals($programa->horaInicio) || $now->lessThanOrEquals($programa->horaFin);
            }
            return $now->between($programa->horaInicio, $programa->horaFin);
        });

        if ($nowPlaying->count() === 0) {
            return [
                'programa' => self::DEFAULT_PROGRAM_NAME,
                'produccion' => self::DEFAULT_PRODUCTION_NAME,
            ];
        }

        $first = $nowPlaying->first();

        return [
            'programa' => $first->name,
            'produccion' => $first->produccion,
        ];
    }
}
