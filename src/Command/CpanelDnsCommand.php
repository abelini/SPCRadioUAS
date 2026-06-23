<?php
declare(strict_types=1);

namespace SPC\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use SPC\Service\CpanelDnsService;

class CpanelDnsCommand extends Command
{
    public function execute(Arguments $args, ConsoleIo $io): int
    {
        $action = $args->getArgumentAt(0);
        $domain = $args->getArgumentAt(1);
        $value = $args->getArgumentAt(2);

        if (!in_array($action, ['add', 'remove'], true)) {
            $io->error('Primer argumento debe ser "add" o "remove"');

            return static::CODE_ERROR;
        }

        if ($domain === null) {
            $io->error('Debes especificar el dominio como segundo argumento');

            return static::CODE_ERROR;
        }

        if ($value === null) {
            $io->error('Debes especificar el valor TXT como tercer argumento');

            return static::CODE_ERROR;
        }

        try {
            $service = new CpanelDnsService();

            if ($action === 'add') {
                $ok = $service->addTxtRecord($domain, $value);
            } else {
                $ok = $service->removeTxtRecord($domain, $value);
            }

            if ($ok) {
                $io->out('OK');

                return static::CODE_SUCCESS;
            }

            $io->error('Error al ' . ($action === 'add' ? 'agregar' : 'remover') . ' record TXT');

            return static::CODE_ERROR;
        } catch (\Exception $e) {
            $io->error($e->getMessage());

            return static::CODE_ERROR;
        }
    }
}
