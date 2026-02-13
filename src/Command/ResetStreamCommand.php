<?php
declare(strict_types=1);

namespace SPC\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Http\Client;
use Cake\Core\Configure;
use Cake\I18n\DateTime;

class ResetStreamCommand extends Command
{
    private const SERVICE_ID = 250;

    public function execute(Arguments $args, ConsoleIo $io): int
    {
        $startTime = DateTime::now();
        $io->out('Proceso iniciado: ' . $startTime->i18nFormat(\IntlDateFormatter::FULL));
        $io->out('--- Iniciando Reset Automático via API (MediaCP) ---');

        $apiKey = Configure::read('SensitiveData.MediaCP.APIKey');

        $http = new Client([
            'scheme' => 'https',
            'host' => 'stream8.mexiserver.com',
            'port' => 2020,
            'basePath' => '/api/' . self::SERVICE_ID . '/media-service/',
            'ssl_verify_peer' => false,
            'timeout' => 30,
            'headers' => [
                'Authorization' => 'Bearer ' . $apiKey,
                'Accept' => 'application/json'
            ]
        ]);

        $io->out('1. SERVICE STOP');

        try {
            $responseStop = $http->post('stop-service');

            if ($responseStop->isOk()) {
                $io->success(' Servicio detenido correctamente.');
            } else {
                $io->warning('!!! Alerta al detener (Código ' . $responseStop->getStatusCode() . '). Puede que ya estuviera detenido.');
                $io->out(' Respuesta: ' . $responseStop->getStringBody());
            }

        } catch (\Exception $e) {
            $io->err('!! Error de conexión al detener: ' . $e->getMessage());
        }

        $io->out('2. WAIT (10s)');
        sleep(10);

        $io->out('3. SERVICE START');

        try {
            $responseStart = $http->post('start-service');

            if ($responseStart->isOk()) {
                $io->success('¡Servicio INICIADO correctamente!');
                $io->out(' Respuesta final: ' . $responseStart->getStringBody());
            } else {
                $io->err('!! Falló el inicio del servicio. Código: ' . $responseStart->getStatusCode());
                $io->out('!! Respuesta: ' . $responseStart->getStringBody());
                return static::CODE_ERROR;
            }

        } catch (\Exception $e) {
            $io->err('!! Error de conexión al iniciar: ' . $e->getMessage());
            return static::CODE_ERROR;
        }

        $io->out('--- Proceso finalizado ---');
        $io->out('Tiempo total: ' . (DateTime::now()->getTimestamp() - $startTime->getTimestamp()) . ' segundos.');
        $io->out();

        return static::CODE_SUCCESS;
    }
}