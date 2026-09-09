<?php

declare(strict_types=1);

namespace SPC\Service;

use Cake\Cache\Cache;
use Cake\I18n\DateTime;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use SPC\DTO\RadioBroadcast;
use SPC\DTO\StreamData;
use SPC\Model\Entity\Programa;
use SPC\Trait\APICacheTrait;


final class NowPlayingService
{
    use APICacheTrait;

    public function get(): RadioBroadcast
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
                    image: Programa::getDefaultCover(musical: false),
                    horaInicio: $rc['inicio'],
                );
            }
            Cache::delete(self::CR_CACHE_KEY, self::CR_CACHE_CONFIG);
        }

        if ($this->isOverrideActive()) {
            return $this->getActiveOverride();
        }

        $programas = TableRegistry::getTableLocator()
            ->get('Programas')
            ->find('allForDay', new DateTime()->dayOfWeek)
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
                image: Programa::getDefaultCover(musical: StreamData::DEFAULT_MUSICAL),
                horaInicio: DateTime::now()->getTimestamp(),
            );
        }

        $first = $nowPlaying->first();

        return new StreamData(
            programa: $first->name,
            produccion: $first->produccion,
            conduccion: $first->conduccion,
            pty: $first->pty,
            ptn: $first->ptn,
            music: $first->musical,
            sm: $first->musical,
            image: $first->image,
            horaInicio: DateTime::createFromFormat('H:i:s', $first->horaInicio->format('H:i:s'))->getTimestamp(),
        );
    }
}
