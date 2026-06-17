<?php
declare(strict_types=1);

namespace SPC\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use SPC\Service\NowPlayingService;
use SPC\Service\Rdi20TelnetService;
use SPC\Service\ShoutcastService;
use Throwable;


class BroadcastCommand extends Command
{
    public function execute(Arguments $args, ConsoleIo $io): int
    {
        $subcommand = $args->getArgumentAt(0);
        if ($subcommand !== 'update') {
            $io->error(sprintf('Subcomando no válido: %s. Uso: bin/cake broadcast update', $subcommand ?? ''));

            return self::CODE_ERROR;
        }

        try {
            $data = (new NowPlayingService())->get();
        } catch (Throwable $e) {
            $io->error('Error al obtener datos: ' . $e->getMessage());

            return self::CODE_ERROR;
        }

        $ts = date('Y-m-d H:i:s');

        $shoutStatus = (new ShoutcastService())->update($data);
        if (str_starts_with($shoutStatus, 'Error')) {
            $io->error(sprintf('[%s][SHOUTCAST] %s', $ts, $shoutStatus));
        }

        $rdsStatus = (new Rdi20TelnetService())->update($data);
        if (str_starts_with($rdsStatus, 'Error') || str_contains($rdsStatus, 'falló')) {
            $io->error(sprintf('[%s][RDSSYSTEM] %s', $ts, $rdsStatus));
        }

        return self::CODE_SUCCESS;
    }
}
