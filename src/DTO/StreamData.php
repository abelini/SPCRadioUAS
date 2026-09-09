<?php

declare(strict_types=1);

namespace SPC\DTO;

use Cake\Core\Configure;
use Cake\I18n\DateTime;
use Cake\I18n\Time;
use JsonSerializable;


final readonly class StreamData extends RadioBroadcast implements JsonSerializable
{
    public function __construct(
        string $programa = '',
        string $produccion = '',
        string $conduccion = '',
        int $pty = 0,
        string $ptn = '',
        bool $music = true,
        bool $sm = true,
        string $image = '',
        int $horaInicio = 0,
        int $durationMinutes = 30,
    ) {
        if ($horaInicio > 0) {
            $tz = Configure::read('App.defaultTimezone');
            $dt = DateTime::createFromTimestamp($horaInicio, $tz);
            $startTime = Time::parse($dt->format('H:i:s'));
            $endTime = Time::parse($dt->addMinutes($durationMinutes)->format('H:i:s'));
        } else {
            $startTime = Time::now();
            $endTime = Time::parse(DateTime::now()->addMinutes($durationMinutes)->format('H:i:s'));
        }

        parent::__construct(
            name: $programa ?: parent::DEFAULT_PROGRAM_NAME,
            producer: $produccion ?: parent::DEFAULT_PRODUCTION_NAME,
            host: $conduccion ?: parent::DEFAULT_CONDUCCION,
            image: $image,
            icon: '',
            slug: $ptn ?: parent::DEFAULT_PTN,
            startTime: $startTime,
            endTime: $endTime,
            PTY: $pty > 0 ? $pty : parent::DEFAULT_PTY,
            PTN: $ptn ?: parent::DEFAULT_PTN,
            SM: $sm,
            music: $music,
            durationMinutes: $durationMinutes,
        );
    }

    public function jsonSerialize(): array
    {
        return [
            'programa' => $this->name,
            'produccion' => $this->producer,
            'pty' => $this->PTY,
            'ptn' => $this->PTN,
            'music' => $this->music,
            'sm' => $this->SM,
            'image' => $this->image,
            'horaInicio' => $this->startTime->format('U'),
            'conduccion' => $this->host,
            'durationMinutes' => $this->durationMinutes,
            'expiresAt' => null,
        ];
    }
}
