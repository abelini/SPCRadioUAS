<?php
declare(strict_types=1);

namespace SPC\DTO;

use Cake\I18n\DateTime;


class Certificate
{
    public function __construct(
        public readonly bool $exists = false,
        public readonly ?DateTime $expiry = null,
        public readonly ?int $daysLeft = null,
        public readonly ?string $issuer = null,
        public readonly ?string $subject = null,
        public readonly array $sans = [],
        public readonly string $certFile = '',
        public readonly string $keyFile = '',
        public readonly string $fullchainFile = '',
        public readonly string $pfxFile = '',
        public readonly bool $pfxExists = false,
        public readonly ?DateTime $pfxAge = null,
        public readonly ?DateTime $lastRenew = null,
        public readonly ?string $error = null,
    ) {}
}
