<?php
declare(strict_types=1);

namespace SPC\Command;

use Cake\Cache\Cache;
use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Core\Configure;
use Cake\Network\Socket;
use SPC\Service\NowPlayingService;
use SPC\Service\Rdi20TelnetService;
use SPC\Service\RdiTelnetClient;
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

        (new ShoutcastService())->update($data);

        $config = Configure::read('SensitiveData.Rdi20');
        $ip = gethostbyname(gethostname());
        $host = str_starts_with($ip, '192.168.') ? $config['local_host'] : $config['remote_host'];

        $socket = new Socket([
            'host' => $host,
            'port' => $config['port'],
            'protocol' => 'tcp',
            'timeout' => 5,
        ]);

        $client = new RdiTelnetClient($socket);
        $rds = new Rdi20TelnetService($client);
        $rds->update($data);

        return self::CODE_SUCCESS;
    }
}
