<?php
declare(strict_types=1);

namespace SPC\Service;

use Cake\Cache\Cache;
use Cake\I18n\DateTime;
use Cake\I18n\Time;
use Cake\ORM\Query\SelectQuery;
use Cake\ORM\TableRegistry;
use SPC\DTO\StreamData;
use SPC\Enum\PTY;
use SPC\Model\Entity\Programa;
use SPC\Trait\APICacheTrait;


final class NowPlayingService
{
    use APICacheTrait;

    public function get(): StreamData
    {
        $rc = Cache::read(self::CR_CACHE_KEY, self::CR_CACHE_CONFIG);
        if ($rc) {
            if (time() - $rc['inicio'] <= self::CR_MAX_TIME) {
                return new StreamData(
                    programa: $rc['evento'],
                    produccion: $rc['produccion'],
                    pty: 0,
                    ptn: 'Enlace',
                    music: false,
                    sm: false,
                    image: Programa::getDefaultCover(musical:false),
                    horaInicio: Time::now(),
                );
            }
            Cache::delete(self::CR_CACHE_KEY, self::CR_CACHE_CONFIG);
        }

        if ($this->isOverrideActive()) {
            return $this->getActiveOverride();
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
            return new StreamData(
                programa: StreamData::DEFAULT_PROGRAM_NAME,
                produccion: StreamData::DEFAULT_PRODUCTION_NAME,
                pty: StreamData::DEFAULT_PTY,
                ptn: StreamData::DEFAULT_PTN,
                music: StreamData::DEFAULT_MUSICAL,
                sm: StreamData::DEFAULT_MUSICAL,
                image: Programa::getDefaultCover(musical: StreamData::DEFAULT_MUSICAL),
                horaInicio: Time::now(),
            );
        }

        $first = $nowPlaying->first();

        return new StreamData(
            programa: $first->name,
            produccion: $first->produccion,
            pty: $first->pty->value,
            ptn: $first->ptn,
            music: $first->musical,
            sm: $first->musical,
            image: $first->image_url,
            horaInicio: $first->horaInicio,
        );
    }
}
