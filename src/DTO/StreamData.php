<?php
declare(strict_types=1);

namespace SPC\DTO;

class StreamData
{
    public function __construct(
        public readonly string $programa,
        public readonly string $produccion,
        public readonly int $pty,
        public readonly string $ptn,
        public readonly bool $music,
        public readonly bool $sm,
    ) {}
}
