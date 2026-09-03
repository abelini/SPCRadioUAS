<?php
declare(strict_types=1);

namespace SPC\DTO;

use Cake\I18n\Time;

final class StreamData
{
    public const string DEFAULT_PROGRAM_NAME = 'Paisajes sonoros';

    public const string DEFAULT_PRODUCTION_NAME = 'Fonoteca';

    public const string DEFAULT_CONDUCCION = 'Auto DJ';

    public const string DEFAULT_PTN = 'Musica';

    public const int DEFAULT_PTY = 12;

    public const bool DEFAULT_MUSICAL = true;

    public const string DEFAULT_HORA_INICIO = '00:00';

    public const int DEFAULT_DURATION_MINUTES = 60;

    public function __construct(
        public readonly string $programa,
        public readonly string $produccion,
        public readonly int $pty,
        public readonly string $ptn,
        public readonly bool $music,
        public readonly bool $sm,
        public readonly string $image,
        public readonly Time $horaInicio,
        public readonly ?string $conduccion = null,
        public readonly ?int $durationMinutes = null,
        public readonly ?int $expiresAt = null,
    ) {}
}
