<?php
declare(strict_types=1);

namespace SPC\Command;

use Cake\Cache\Cache;
use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\I18n\DateTime;
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

        $now = DateTime::now()->format('Y-m-d H:i:s');

        $io->info(sprintf('[%s] --- Diagnóstico RDS (Telnet) ---', $now));
        $io->info(sprintf('[%s]   Destino:    %s:%d (TCP)', $now, Rdi20TelnetService::HOST, Rdi20TelnetService::PORT));
        $io->info(sprintf('[%s]   Payload:    %s', $now, json_encode($payload, JSON_UNESCAPED_UNICODE)));
        $io->info(sprintf('[%s]   Texto:      %s', $now, $text));
        $io->info(sprintf('[%s]   Longitud:   %d bytes', $now, strlen($payload)));

        $rds = new Rdi20TelnetService();

        if ($rds->send($payload)) {
            $this->cachePayload($payload);
            $io->success(sprintf('[%s]   Enviado:    Aceptado (+)', $now));
        } else {
            $io->error(sprintf('[%s]   Falló:      %s', $now, $rds->getLastError()));
            $resp = $rds->getLastResponse();
            if ($resp) {
                $io->info(sprintf('[%s]   Respuesta:  %s', $now, json_encode($resp)));
            }
        }

        $io->info(sprintf('[%s] ------------------------', $now));

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
