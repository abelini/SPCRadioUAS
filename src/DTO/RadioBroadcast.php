<?php

declare(strict_types=1);

namespace SPC\DTO;

use Cake\I18n\Time;


abstract readonly class RadioBroadcast
{
    public const int DEFAULT_ID = 999;
    public const string DEFAULT_NAME = 'Paisajes sonoros';
    public const string DEFAULT_PRODUCER = 'Selecciones de la Fonoteca';
    public const string DEFAULT_HOST = 'Radio DJ';
    public const string DEFAULT_PTN = 'music';
    public const int DEFAULT_PTY = 12;
    public const bool DEFAULT_MUSICAL = true;
    public const int DEFAULT_DURATION_MINUTES = 60;

    public function __construct(
        public readonly string $name,
        public readonly string $producer,
        public readonly string $host,
        public readonly string $image,
        public readonly string $icon,
        public readonly string $slug,
        public readonly Time $startTime,
        public readonly Time $endTime,
        public readonly int $PTY = self::DEFAULT_PTY,
        public readonly string $PTN = self::DEFAULT_PTN,
        public readonly bool $SM = true,
        public readonly bool $music = self::DEFAULT_MUSICAL,
        public readonly int $ID = self::DEFAULT_ID,
        public readonly int $durationMinutes = self::DEFAULT_DURATION_MINUTES,
    ) {}
}
