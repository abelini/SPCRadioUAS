<?php

declare(strict_types=1);

namespace SPC\DTO;


final class StreamData
{
    public const string DEFAULT_PROGRAM_NAME = 'Paisajes sonoros';

    public const string DEFAULT_PRODUCTION_NAME = 'Fonoteca';

    public const string DEFAULT_CONDUCCION = 'Auto DJ';

    public const string DEFAULT_PTN = 'Musica';

    public const int DEFAULT_PTY = 12;

    public const bool DEFAULT_MUSICAL = true;

    public const int DEFAULT_DURATION_MINUTES = 60;

    public function __construct(
        public readonly string $programa,
        public readonly string $produccion,
        public readonly int $pty,
        public readonly string $ptn,
        public readonly bool $music,
        public readonly bool $sm,
        public readonly string $image,
        public readonly int $horaInicio,
        public readonly string $conduccion = self::DEFAULT_CONDUCCION,
        public readonly int $durationMinutes = self::DEFAULT_DURATION_MINUTES,
        public readonly ?int $expiresAt = null,
    ) {}
}
