<?php

declare(strict_types=1);

namespace SPC\DTO;

use Cake\I18n\Time;

final readonly class RadioProgram extends RadioBroadcast
{
    public function __construct(
        int $ID = parent::DEFAULT_ID,
        string $name = parent::DEFAULT_NAME,
        string $producer = parent::DEFAULT_PRODUCER,
        string $host = parent::DEFAULT_HOST,
        Time $startTime,
        Time $endTime,
        string $slug,
        string $image,
        string $icon,
        int $PTY = parent::DEFAULT_PTY,
        string $PTN = parent::DEFAULT_PTN,
        bool $music = parent::DEFAULT_MUSICAL,
    ) {
        parent::__construct(
            name: $name,
            producer: $producer,
            host: $host,
            image: $image,
            icon: $icon,
            slug: $slug,
            startTime: $startTime,
            endTime: $endTime,
            PTY: $PTY,
            PTN: $PTN,
            SM: $music,
            music: $music,
            ID: $ID,
        );
    }
}
