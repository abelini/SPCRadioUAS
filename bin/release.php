<?php

declare(strict_types=1);

require_once __DIR__ . '/ReleaseManager.php';

$bumpType = $argv[1] ?? '';

try {
    (new ReleaseManager())->release($bumpType);
} catch (Throwable $exception) {
    fwrite(STDERR, $exception->getMessage() . "\n");
    exit(1);
}
