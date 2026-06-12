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

        $xtxtPayload = 'XTXT=' . $text . "\r\n";
        $ptyPayload = 'XPTY=' . $data['pty'] . "\r\n";

        $cacheValue = json_encode(['xtxt' => $text, 'pty' => $data['pty']]);

        if (!$this->hasChanged($cacheValue)) {
            return self::CODE_SUCCESS;
        }

        $now = DateTime::now()->format('Y-m-d H:i:s');

        $io->info(sprintf('[%s] --- Diagnóstico RDS (Telnet) ---', $now));
        $io->info(sprintf('[%s]   Destino:    %s:%d (TCP)', $now, Rdi20TelnetService::HOST, Rdi20TelnetService::PORT));
        $io->info(sprintf('[%s]   RadioText:  %s', $now, json_encode($xtxtPayload, JSON_UNESCAPED_UNICODE)));
        $io->info(sprintf('[%s]   PTY:        %s', $now, json_encode($ptyPayload, JSON_UNESCAPED_UNICODE)));
        $io->info(sprintf('[%s]   Texto:      %s', $now, $text));

        $rds = new Rdi20TelnetService();
        $success = true;

        if (!$rds->send($xtxtPayload)) {
            $io->error(sprintf('[%s]   XTXT falló: %s', $now, $rds->getLastError()));
            $success = false;
        } else {
            $io->success(sprintf('[%s]   XTXT enviado (+)', $now));
        }

        if (!$rds->send($ptyPayload)) {
            $io->error(sprintf('[%s]   XPTY falló: %s', $now, $rds->getLastError()));
            $success = false;
        } else {
            $io->success(sprintf('[%s]   XPTY enviado (+)', $now));
        }

        if ($success) {
            $this->cachePayload($cacheValue);
        }

        $io->info(sprintf('[%s] ------------------------', $now));

        return self::CODE_SUCCESS;
    }

    private function hasChanged(string $cacheValue): bool
    {
        $last = Cache::read(self::CACHE_KEY);

        return $last !== $cacheValue;
    }

    private function cachePayload(string $cacheValue): void
    {
        Cache::write(self::CACHE_KEY, $cacheValue);
    }
}
