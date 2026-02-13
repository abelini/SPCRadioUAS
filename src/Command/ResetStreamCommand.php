<?php
declare(strict_types=1);

namespace SPC\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Http\Client;
use Cake\I18n\DateTime;
use Cake\Core\Configure;

class ResetStreamCommand extends Command
{
    protected string $panelUrl = 'https://stream8.mexiserver.com:2020';

    public function execute(Arguments $args, ConsoleIo $io): int
    {


        $http = new Client([
            'scheme' => 'https',
            'host' => 'stream8.mexiserver.com',
            'port' => 2020,
            'ssl_verify_peer' => false,
            'timeout' => 30,
            'redirect' => true
        ]);

        $io->out('Proceso iniciado: ' . DateTime::now()->i18nFormat(\IntlDateFormatter::FULL));

        $io->out('--- Reinicio Automático ---');

        // ---------------------------------------------------------
        // PASO 1: INICIAR SESIÓN (Obtener Cookies)
        // ---------------------------------------------------------
        $io->out('1. CP AUTHENTICATION');

        try {
            $loginResponse = $http->post('/index.php', [
                'username' => Configure::read('SensitiveData.TVStream.Username'),
                'user_password' => Configure::read('SensitiveData.TVStream.Password'),
                'language' => 'default'
            ]);

            // Capturamos las cookies de sesión (PHPSESSID)
            $cookies = $loginResponse->getCookieCollection();

            if ($cookies->count() === 0) {
                $io->err('Error: No se recibieron cookies de sesión. Revisa usuario/pass.');
                return static::CODE_ERROR;
            }

            $io->success('Login correcto. Cookies obtenidas.');

        } catch (\Exception $e) {
            $io->err('Excepción al intentar login: ' . $e->getMessage());
            return static::CODE_ERROR;
        }

        // ---------------------------------------------------------
        // PASO 2: DETENER SERVICIO
        // ---------------------------------------------------------
        $io->out('2. SERVICE STOP');

        $http->setConfig('basePath', '/controller/MediaService');

        try {
            $stopResponse = $http->get('/stopService/250', options: [
                'cookies' => ['PHPSESSID']
            ]);

            if ($stopResponse->isOk()) {
                $io->success('Orden de STOP enviada correctamente.');
            } else {
                $io->err('El servidor respondió error al detener: ' . $stopResponse->getStatusCode());
            }

        } catch (\Exception $e) {
            $io->err('Error de conexión al detener: ' . $e->getMessage());
        }

        // ---------------------------------------------------------
        // PASO 3: ESPERA DE SEGURIDAD
        // ---------------------------------------------------------
        $io->out('3. HOLD (10s)');
        sleep(10);

        // ---------------------------------------------------------
        // PASO 4: REINICIAR SERVICIO
        // ---------------------------------------------------------
        $io->out('4. SERVICE RESTART');

        try {
            // Reutilizamos las mismas cookies de la sesión
            $restartResponse = $http->get('/restartService/250', options: [
                'cookies' => ['PHPSESSID']
            ]);

            if ($restartResponse->isOk()) {
                $io->success('Orden de RESTART enviada correctamente.');
            } else {
                $io->err('El servidor respondió error al reiniciar: ' . $restartResponse->getStatusCode());
                return static::CODE_ERROR;
            }

        } catch (\Exception $e) {
            $io->err('Error de conexión al reiniciar: ' . $e->getMessage());
            return static::CODE_ERROR;
        }

        $io->success('--- Proceso completado exitosamente ---');
        $io->success("\n");

        return static::CODE_SUCCESS;
    }
}