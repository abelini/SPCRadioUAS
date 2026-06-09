<?php
declare(strict_types=1);

namespace SPC\Command;

use Cake\Cache\Cache;
use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use SPC\Service\NowPlayingService;
use SPC\Service\Rdi20Service;

class SendRdsCommand extends Command
{
    private const int MAX_RT_LENGTH = 64;

    private const string CACHE_KEY = 'last_sent_rds';

    public function execute(Arguments $args, ConsoleIo $io): int
    {
        $data = (new NowPlayingService())->get();
        $text = $data['produccion'] . ' - ' . $data['programa'];
        $text = mb_substr($text, 0, self::MAX_RT_LENGTH);

        $payload = 'TEXT=' . $text . "\r\n";

        if (!$this->hasChanged($payload)) {
            return self::CODE_SUCCESS;
        }

        $rds = new Rdi20Service();
        if ($rds->send($payload)) {
            $this->cachePayload($payload);
            $io->success(sprintf('RDS enviado: %s', $text));
            return self::CODE_SUCCESS;
        }

        $io->error('Falló el envío al RDI 20');
        return self::CODE_ERROR;
    }

    private function hasChanged(string $payload): bool
    {
        $last = Cache::read(self::CACHE_KEY);
        return $last !== $payload;
    }

    private function cachePayload(string $payload): void
    {
        Cache::write(self::CACHE_KEY, $payload);
    }
}
