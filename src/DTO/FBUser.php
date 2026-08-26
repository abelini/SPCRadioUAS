<?php

declare(strict_types=1);

namespace SPC\DTO;


class FBUser
{
    public function __construct(
        public readonly string $name = 'Auto-response'
    ) {}
}