<?php
declare(strict_types=1);

namespace SPC\Command;

use Cake\Cache\Cache;
use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use SPC\Service\NowPlayingService;
use SPC\Service\Rdi20TelnetService;

class SendRdsCommand extends Command
{
    private const int MAX_RT_LENGTH = 64;

    private const string CACHE_KEY = 'last_sent_rds';

    public function execute(Arguments $args, ConsoleIo $io): int
    {
        $data = (new NowPlayingService())->get();
        $text = $data['produccion'] . ' - ' . $data['programa'];
        $text = mb_substr($text, 0, self::MAX_RT_LENGTH);

        $payload = 'XTXT=' . $text . "\r\n";

        if (!$this->hasChanged($payload)) {
            return self::CODE_SUCCESS;
        }

        $io->info('--- Diagnóstico RDS (Telnet) ---');
        $io->info(sprintf('  Destino:     %s:%d (TCP)', Rdi20TelnetService::HOST, Rdi20TelnetService::PORT));
        $io->info(sprintf('  Payload:     %s', json_encode($payload, JSON_UNESCAPED_UNICODE)));
        $io->info(sprintf('  Texto:       %s', $text));
        $io->info(sprintf('  Longitud:    %d bytes', strlen($payload)));

        $rds = new Rdi20TelnetService();

        if ($rds->send($payload)) {
            $this->cachePayload($payload);
            $io->success('  Enviado:     Aceptado (+)');
        } else {
            $io->error(sprintf('  Falló:       %s', $rds->getLastError()));
            $resp = $rds->getLastResponse();
            if ($resp) {
                $io->info(sprintf('  Respuesta:   %s', json_encode($resp)));
            }
        }

        $io->info('------------------------');

        return self::CODE_SUCCESS;
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
