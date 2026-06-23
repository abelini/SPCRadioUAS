<?php
declare(strict_types=1);

namespace SPC\Command;

use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Core\Configure;

class SslRenewCommand extends Command
{
    protected function buildOptionParser(\Cake\Console\ConsoleOptionParser $parser): \Cake\Console\ConsoleOptionParser
    {
        $parser->setDescription(
            'Renueva un certificado SSL vía acme.sh (Let\'s Encrypt / ZeroSSL) y genera .pfx. '
            . 'Los valores por defecto se leen de Configure::read(\'SSLGeneration.*\') en app_local.php.'
        );

        $parser->addArgument('domain', [
            'help' => 'El dominio (subdominio DDNS) a renovar. Ej: midns.midominio.com',
            'required' => false,
        ]);
        $parser->addArgument('email', [
            'help' => 'Email para el registro en la CA. Si se omite se usa admin@<dominio>',
            'required' => false,
        ]);
        $parser->addArgument('pfx-destination', [
            'help' => 'Ruta donde copiar el archivo .pfx generado. Opcional.',
            'required' => false,
        ]);

        return $parser;
    }

    public function execute(Arguments $args, ConsoleIo $io): int
    {
        $domain = $args->getArgumentAt(0);
        if ($domain === null) {
            $domain = Configure::read('SSLGeneration.domain');
        }
        if ($domain === null) {
            $io->error('Debes especificar el dominio como primer argumento o configurar SSLGeneration.domain en app_local.php');

            return static::CODE_ERROR;
        }

        $email = $args->getArgumentAt(1) ?? Configure::read('SSLGeneration.email');
        if ($email === null) {
            $email = 'admin@' . $domain;
            $io->warning('No se especificó email. Usando: ' . $email);
        }

        $pfxDest = $args->getArgumentAt(2) ?? Configure::read('SSLGeneration.pfxDestination');

        $acmeHome = Configure::read('SSLGeneration.acmeHome') ?? getenv('HOME') . '/.acme.sh';
        $webroot = Configure::read('SSLGeneration.webroot') ?? ROOT . DS . 'webroot';
        $dnsProvider = Configure::read('SSLGeneration.dnsProvider') ?? 'webroot';
        $ca = Configure::read('SSLGeneration.ca') ?? 'letsencrypt';

        $acmeSh = $acmeHome . '/acme.sh';

        // 1. Check acme.sh is installed
        if (!$this->isInstalled($acmeSh)) {
            $io->error('acme.sh no está instalado. Ejecuta: curl -sL https://get.acme.sh | sh');

            return static::CODE_ERROR;
        }

        $io->out('acme.sh ya está instalado');

        // 2. Set CA
        $this->runCommand([$acmeSh, '--set-default-ca', '--server', $ca], $io);

        // 3. Issue / renew certificate
        $io->out("Procesando certificado para: {$domain}");
        $io->out('Método DNS: ' . $dnsProvider);

        $hookScript = null;

        try {
            if ($dnsProvider === 'cpanel') {
                $hookScript = $this->createCpanelHookScript();
                putenv('ACMESH_DNS_MANUAL_CMD=' . escapeshellarg($hookScript) . ' add');
                putenv('ACMESH_DNS_MANUAL_CLEANUP=' . escapeshellarg($hookScript) . ' remove');

                $cmd = [$acmeSh, '--issue', '-d', $domain, '--dns', 'dns_manual_hook', '--force', '--dnssleep', '120'];
            } else {
                $cmd = [$acmeSh, '--issue', '-d', $domain, '--webroot', $webroot, '--force'];
            }

            $this->runCommand($cmd, $io, $exitCode);
            if ($exitCode !== 0) {
                $io->error('Error al obtener/renovar el certificado');

                return static::CODE_ERROR;
            }
        } finally {
            if ($hookScript !== null && file_exists($hookScript)) {
                unlink($hookScript);
            }
        }

        // 4. Verify cert files exist
        $certDir = $acmeHome . '/' . $domain;
        $certFile = $certDir . '/' . $domain . '.cer';
        $keyFile = $certDir . '/' . $domain . '.key';
        $fullchainFile = $certDir . '/fullchain.cer';

        if (!file_exists($certFile) || !file_exists($keyFile)) {
            $io->error('No se encontraron los archivos del certificado en: ' . $certDir);

            return static::CODE_ERROR;
        }

        // 5. Generate PFX
        $pfxFile = $certDir . '/' . $domain . '.pfx';
        $pfxPass = Configure::read('SSLGeneration.pfxPassword') ?? '';
        $io->out('Generando PFX...');

        if ($pfxPass !== '') {
            $opensslCmd = sprintf(
                'openssl pkcs12 -export -out %s -inkey %s -in %s -certfile %s -passout pass:%s',
                escapeshellarg($pfxFile),
                escapeshellarg($keyFile),
                escapeshellarg($certFile),
                escapeshellarg($fullchainFile),
                escapeshellarg($pfxPass)
            );
        } else {
            $opensslCmd = sprintf(
                'openssl pkcs12 -export -out %s -inkey %s -in %s -certfile %s -passout pass:',
                escapeshellarg($pfxFile),
                escapeshellarg($keyFile),
                escapeshellarg($certFile),
                escapeshellarg($fullchainFile)
            );
        }

        exec($opensslCmd . ' 2>&1', $output, $exitCode);
        if ($exitCode !== 0) {
            $io->error('Error al generar PFX: ' . implode("\n", $output));

            return static::CODE_ERROR;
        }
        $io->success('PFX generado: ' . $pfxFile);

        // 6. Copy PFX to destination if configured
        if ($pfxDest !== null) {
            $io->out('Copiando PFX a: ' . $pfxDest);
            $destDir = dirname($pfxDest);
            if (!is_dir($destDir)) {
                mkdir($destDir, 0755, true);
            }
            if (copy($pfxFile, $pfxDest)) {
                $io->success('PFX copiado a: ' . $pfxDest);
            } else {
                $io->error('Error al copiar PFX a: ' . $pfxDest);
            }
        }

        // 7. Summary
        $io->out('');
        $io->success('=== Certificado renovado exitosamente ===');
        $io->out('Dominio:    ' . $domain);
        $io->out('Cert:       ' . $certFile);
        $io->out('Key:        ' . $keyFile);
        $io->out('Fullchain:  ' . $fullchainFile);
        $io->out('PFX:        ' . $pfxFile);
        if ($pfxDest !== null) {
            $io->out('PFX copiado a: ' . $pfxDest);
        }

        return static::CODE_SUCCESS;
    }

    private function isInstalled(string $acmeSh): bool
    {
        return file_exists($acmeSh) && is_executable($acmeSh);
    }

    private function createCpanelHookScript(): string
    {
        $cakeBin = ROOT . DS . 'bin' . DS . 'cake.php';
        $phpBin = PHP_BINARY;
        $tmpFile = tempnam(sys_get_temp_dir(), 'acme_cpanel_');

        $content = sprintf(
            "#!/bin/bash\n%s %s cpanel_dns \"\$@\"\n",
            escapeshellarg($phpBin),
            escapeshellarg($cakeBin)
        );

        file_put_contents($tmpFile, $content);
        chmod($tmpFile, 0755);

        return $tmpFile;
    }

    private function runCommand(array $args, ConsoleIo $io, ?int &$exitCode = null): array
    {
        $cmd = implode(' ', array_map('escapeshellarg', $args));

        $io->verbose('Ejecutando: ' . $cmd);

        exec($cmd . ' 2>&1', $output, $exitCode);

        foreach ($output as $line) {
            $io->out('  ' . $line);
        }

        return $output;
    }
}
