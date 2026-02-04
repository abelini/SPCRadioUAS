<?php
declare(strict_types=1);

namespace SPC\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Http\Client;

class ResetStreamCommand extends Command
{
    public function execute(Arguments $args, ConsoleIo $io): int
    {
        $http = new Client([
            'ssl_verify_peer' => false, // A veces necesario si el cert del server externo da problemas
            'timeout' => 30
        ]);

        $stopUrl = 'https://stream8.mexiserver.com:2020/controller/MediaService/stopService/250';
        $restartUrl = 'https://stream8.mexiserver.com:2020/controller/MediaService/restartService/250';

        // 1. Detener el servicio
        $io->out('Deteniendo servicio...');
        try {
            $responseStop = $http->get($stopUrl);
            if ($responseStop->isOk()) {
                $io->success('Servicio detenido correctamente.');
            } else {
                $io->warning('El servidor respondió con error al intentar detener: ' . $responseStop->getStatusCode());
            }
        } catch (\Exception $e) {
            $io->err('Error de conexión al detener: ' . $e->getMessage());
        }

        // 2. Esperar 10 segundos
        $io->out('Esperando 10 segundos...');
        sleep(10);

        // 3. Reiniciar el servicio
        $io->out('Reiniciando servicio...');
        try {
            $responseStart = $http->get($restartUrl);
            if ($responseStart->isOk()) {
                $io->success('Servicio reiniciado exitosamente.');
            } else {
                $io->warning('El servidor respondió con error al intentar reiniciar: ' . $responseStart->getStatusCode());
            }
        } catch (\Exception $e) {
            $io->err('Error de conexión al reiniciar: ' . $e->getMessage());
        }

        return static::CODE_SUCCESS;
    }
}