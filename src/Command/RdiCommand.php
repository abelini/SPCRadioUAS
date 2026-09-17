<?php

declare(strict_types=1);

namespace SPC\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Core\Configure;
use Cake\I18n\DateTime;
use Cake\Log\Log;
use SPC\Service\RdiTelnetClient;
use Throwable;

/**
 * Comando para administrar el encoder RDS RDi20.
 *
 * Uso: bin/cake rdi restart
 */
class RdiCommand extends Command
{
    /**
     * Ejecuta el subcomando solicitado.
     *
     * @param \Cake\Console\Arguments $args Argumentos de la línea de comandos.
     * @param \Cake\Console\ConsoleIo $io Salida de consola.
     * @return int Código de salida (CODE_SUCCESS o CODE_ERROR).
     */
    public function execute(Arguments $args, ConsoleIo $io): int
    {
        $subcommand = $args->getArgumentAt(0);
        if ($subcommand !== 'restart') {
            $io->error(sprintf('Subcomando no válido: %s. Uso: bin/cake rdi restart', $subcommand ?? ''));

            return static::CODE_ERROR;
        }

        return $this->restart($io);
    }

    /**
     * Guarda la configuración a NVRAM (XSAV) y reinicia la CPU (XRES).
     *
     * El XRES se envía en modo fire-and-forget: como el reinicio tumba la
     * conexión TCP, la ausencia de respuesta se considera éxito.
     *
     * @param \Cake\Console\ConsoleIo $io Salida de consola.
     * @return int Código de salida (CODE_SUCCESS o CODE_ERROR).
     */
    protected function restart(ConsoleIo $io): int
    {
        $ts = DateTime::now()->i18nFormat('yyyy-MM-dd HH:mm:ss');
        $io->out(sprintf('[%s] --- Reinicio del RDi20 ---', $ts));

        try {
            $client = RdiTelnetClient::getInstance();

            $io->out('1. CONNECT');
            if (!$client->connect()) {
                $error = sprintf('[%s] Conexión falló: %s', $ts, $client->getLastError());
                $io->error($error);
                Log::write(LOG_ERR, $error, ['scope' => 'rds']);

                return static::CODE_ERROR;
            }
            $io->success(' Conectado.');

            $io->out('2. LOGIN');
            $config = Configure::read('SensitiveData.Rdi20');
            if (!$client->login($config['username'], $config['password'])) {
                $error = sprintf('[%s] Login falló: %s', $ts, $client->getLastError());
                $io->error($error);
                Log::write(LOG_ERR, $error, ['scope' => 'rds']);
                $client->disconnect();

                return static::CODE_ERROR;
            }
            $io->success(' Autenticado.');

            $io->out('3. XSAV (Persistance)');
            $saveResponse = $client->save();
            if (!str_contains($saveResponse, '+')) {
                $warning = sprintf('[%s] XSAV respondió sin "+": %s. Se continúa con el reinicio.', $ts, json_encode($saveResponse));
                $io->warning($warning);
                Log::write(LOG_WARNING, $warning, ['scope' => 'rds']);
            } else {
                $io->success(' Configuración guardada.');
            }

            $io->out('4. WAIT (2s)');
            sleep(2);

            $io->out('5. XRES (Reboot)');
            $client->reboot();
            $client->disconnect();

            $success = sprintf('[%s] Comando XRES enviado, RDi20 reiniciando.', $ts);
            $io->success($success);
            Log::write(LOG_INFO, $success, ['scope' => 'rds']);

            return static::CODE_SUCCESS;
        } catch (Throwable $e) {
            $error = sprintf('[%s] Error inesperado: %s', $ts, $e->getMessage());
            $io->error($error);
            Log::write(LOG_ERR, $error, ['scope' => 'rds']);

            return static::CODE_ERROR;
        }
    }
}
