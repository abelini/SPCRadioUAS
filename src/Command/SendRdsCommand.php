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

    private const array PTY_FALLBACKS = [10, 12, 13, 16, 17, 19, 20];

    private function buildText(array $data): string
    {
        $search = array('á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú', 'ñ', 'Ñ', 'ü', 'Ü');
        $replace = array('a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U', 'n', 'N', 'u', 'U');
        $text = match($data['music']) {
            false => $data['produccion'] . ' - ' . $data['programa'],
            true => $data['programa'],
        };

        return mb_substr(str_replace($search, $replace, $text), 0, self::MAX_RT_LENGTH);
    }

    public function execute(Arguments $args, ConsoleIo $io): int
    {
        $data = (new NowPlayingService())->get();

        $text = $this->buildText($data);

        $pty = $data['pty'];

        if ($pty === null) {
            $fallbackKey = 'last_pty_' . md5($text);
            $pty = Cache::remember($fallbackKey, function () {
                return self::PTY_FALLBACKS[array_rand(self::PTY_FALLBACKS)];
            });
        }

        $xtxtPayload = 'XTXT=' . $text . "\r\n";
        $ptyPayload = 'XPTY=' . $pty . "\r\n";
        $xfmsPayload = 'XFMS=' . ($data['music'] ? '1' : '0') . "\r\n";

        $cacheValue = json_encode(['xtxt' => $text, 'pty' => $pty, 'xfms' => $data['music']]);

        if (!$this->hasChanged($cacheValue)) {
            return self::CODE_SUCCESS;
        }

        $now = DateTime::now()->format('Y-m-d H:i:s');

        $rds = new Rdi20TelnetService();

        $io->info(sprintf('[%s] --- Diagnóstico RDS (Telnet) ---', $now));
        $io->info(sprintf('[%s]   Destino:    %s:%d (TCP)', $now, $rds->getHost(), Rdi20TelnetService::PORT));
        $io->info(sprintf('[%s]   RadioText:  %s', $now, json_encode($xtxtPayload, JSON_UNESCAPED_UNICODE)));
        $io->info(sprintf('[%s]   PTY:        %s', $now, json_encode($ptyPayload, JSON_UNESCAPED_UNICODE)));
        $io->info(sprintf('[%s]   FMS:        %s', $now, json_encode($xfmsPayload, JSON_UNESCAPED_UNICODE)));
        $io->info(sprintf('[%s]   Texto:      %s', $now, $text));

        
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

        if (!$rds->send($xfmsPayload)) {
            $io->error(sprintf('[%s]   XFMS falló: %s', $now, $rds->getLastError()));
            $success = false;
        } else {
            $io->success(sprintf('[%s]   XFMS enviado (+)', $now));
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
