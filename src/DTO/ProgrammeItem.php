<?php

declare(strict_types=1);

namespace SPC\DTO;

use Cake\I18n\Time;

final class ProgrammeItem
{
    public function __construct(
        public readonly int $ID,
        public readonly string $name,
        public readonly string $produccion,
        public readonly string $image,
        public readonly string $icon,
        public readonly Time $horaInicio,
        public readonly Time $horaFin,
    ) {}
}
