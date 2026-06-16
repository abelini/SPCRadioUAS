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

        $io->out(sprintf('[%s][SHOUTCAST] %s', $ts, (new ShoutcastService())->update($data)));
        $io->out(sprintf('[%s][RDSSYSTEM] %s', $ts, (new Rdi20TelnetService())->update($data)));

        return self::CODE_SUCCESS;
    }
}
