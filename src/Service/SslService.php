<?php
declare(strict_types=1);

namespace SPC\Service;

use Cake\Core\Configure;

class SslService
{
    public function getDomain(): ?string
    {
        return Configure::read('SSLGeneration.domain');
    }

    public function getEmail(): string
    {
        return Configure::read('SSLGeneration.email') ?? 'admin@' . ($this->getDomain() ?? 'example.com');
    }

    public function getPfxPassword(): string
    {
        return Configure::read('SSLGeneration.pfxPassword') ?? '';
    }

    public function getPfxDestination(): ?string
    {
        return Configure::read('SSLGeneration.pfxDestination');
    }

    public static function isWindows(): bool
    {
        return PHP_OS_FAMILY === 'Windows';
    }

    public static function isLocalhost(): bool
    {
        $host = $_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'] ?? '';

        return in_array($host, ['localhost', '127.0.0.1', '::1'], true)
            || str_starts_with($host, '192.168.')
            || str_starts_with($host, '10.');
    }

    public static function canRunAcme(): bool
    {
        return !self::isWindows() && !self::isLocalhost();
    }

    public static function findOpenssl(): ?string
    {
        $candidates = ['openssl'];

        if (self::isWindows()) {
            $programFiles = getenv('ProgramFiles') ?: 'C:\Program Files';
            $candidates = [
                'openssl',
                $programFiles . '\OpenSSL-Win64\bin\openssl.exe',
                $programFiles . '\OpenSSL-Win32\bin\openssl.exe',
                'C:\OpenSSL-Win64\bin\openssl.exe',
                'C:\OpenSSL-Win32\bin\openssl.exe',
                getenv('SystemRoot') . '\System32\openssl.exe',
            ];
        }

        foreach ($candidates as $bin) {
            $cmd = self::isWindows()
                ? 'where.exe ' . escapeshellarg($bin) . ' 2>NUL'
                : 'which ' . escapeshellarg($bin) . ' 2>/dev/null';

            exec($cmd, $output, $code);
            if ($code === 0 && !empty($output[0])) {
                return $output[0];
            }
        }

        return null;
    }

    public function getAcmeHome(): string
    {
        return Configure::read('SSLGeneration.acmeHome') ?? (getenv('HOME') ?: '/root') . '/.acme.sh';
    }

    public function getWebroot(): string
    {
        return Configure::read('SSLGeneration.webroot') ?? (defined('ROOT') ? ROOT . DS . 'webroot' : '/var/www/html/webroot');
    }

    public function isAcmeInstalled(): bool
    {
        $acmeSh = $this->getAcmeHome() . '/acme.sh';

        return file_exists($acmeSh) && is_executable($acmeSh);
    }

    public function getCertInfo(string $domain): array
    {
        $acmeHome = $this->getAcmeHome();
        $certDir = $acmeHome . '/' . $domain;
        $certFile = $certDir . '/' . $domain . '.cer';
        $keyFile = $certDir . '/' . $domain . '.key';
        $fullchainFile = $certDir . '/fullchain.cer';
        $pfxDest = $this->getPfxDestination();

        $info = [
            'exists' => false,
            'expiry' => null,
            'expiryTimestamp' => null,
            'daysLeft' => null,
            'issuer' => null,
            'subject' => null,
            'sans' => [],
            'certFile' => $certFile,
            'keyFile' => $keyFile,
            'fullchainFile' => $fullchainFile,
            'pfxFile' => $certDir . '/' . $domain . '.pfx',
            'pfxExists' => false,
            'pfxAge' => null,
            'lastRenew' => null,
            'source' => 'acme',
            'error' => null,
        ];

        $targetFile = $certFile;

        if (!file_exists($certFile)) {
            // Try to read from the destination PFX instead
            if ($pfxDest !== null && file_exists($pfxDest)) {
                $pfxPass = $this->getPfxPassword();
                $targetPfx = $pfxDest;
                $info['pfxFile'] = $pfxDest;
                $info['pfxExists'] = true;
                $info['pfxAge'] = filemtime($pfxDest);
                $info['source'] = 'pfx';

                $opensslBin = self::findOpenssl();
                if ($opensslBin === null) {
                    $info['error'] = 'No se encontró OpenSSL en el sistema.';

                    return $info;
                }

                $passOpt = $pfxPass !== ''
                    ? '-passin pass:' . $pfxPass
                    : '-passin pass:';

                exec(
                    sprintf(
                        '%s pkcs12 -in %s -clcerts -nokeys %s 2>&1',
                        escapeshellarg($opensslBin),
                        escapeshellarg(str_replace('\\', '/', $targetPfx)),
                        $passOpt
                    ),
                    $pemOutput,
                    $exitCode
                );

                if ($exitCode !== 0) {
                    $info['error'] = 'OpenSSL no pudo leer el PFX: ' . ($pemOutput[0] ?? 'error desconocido');

                    return $info;
                }

                if (empty($pemOutput)) {
                    $info['error'] = 'El PFX no contiene un certificado (vació al extraer).';

                    return $info;
                }

                $pem = implode("\n", $pemOutput);

                // Parse from PEM string via temp file
                $tmpFile = tempnam(sys_get_temp_dir(), 'ssl_');
                file_put_contents($tmpFile, $pem);
                $targetFile = $tmpFile;
                $info['exists'] = true;
            } else {
                return $info;
            }
        }

        $info['exists'] = true;
        if ($info['source'] === 'acme') {
            $info['lastRenew'] = filemtime($targetFile);
        }

        // Parse expiry
        exec(
            'openssl x509 -in ' . escapeshellarg($targetFile) . ' -noout -enddate 2>&1',
            $endDateOutput,
            $exitCode
        );

        if ($exitCode === 0 && !empty($endDateOutput[0])) {
            $endDateStr = substr($endDateOutput[0], 9);
            $timestamp = strtotime($endDateStr);
            if ($timestamp !== false) {
                $info['expiry'] = date('Y-m-d H:i:s', $timestamp);
                $info['expiryTimestamp'] = $timestamp;
                $info['daysLeft'] = (int) ceil(($timestamp - time()) / 86400);
            }
        }

        // Parse issuer
        exec(
            'openssl x509 -in ' . escapeshellarg($targetFile) . ' -noout -issuer 2>&1',
            $issuerOutput
        );
        if (!empty($issuerOutput[0])) {
            $info['issuer'] = substr($issuerOutput[0], 8);
        }

        // Parse subject
        exec(
            'openssl x509 -in ' . escapeshellarg($targetFile) . ' -noout -subject 2>&1',
            $subjectOutput
        );
        if (!empty($subjectOutput[0])) {
            $info['subject'] = substr($subjectOutput[0], 9);
        }

        // Parse SANs
        exec(
            'openssl x509 -in ' . escapeshellarg($targetFile) . ' -noout -ext subjectAltName 2>&1',
            $sanOutput
        );
        $sanText = implode("\n", $sanOutput);
        if (preg_match_all('/DNS:([^\s,]+)/', $sanText, $matches)) {
            $info['sans'] = $matches[1];
        }

        // Clean up temp file
        if (isset($tmpFile)) {
            unlink($tmpFile);
        }

        // PFX info (from acme home)
        if ($info['source'] === 'acme') {
            $acmePfx = $certDir . '/' . $domain . '.pfx';
            if (file_exists($acmePfx)) {
                $info['pfxExists'] = true;
                $info['pfxAge'] = filemtime($acmePfx);
                $info['pfxFile'] = $acmePfx;
            }
            // Also check destination
            if ($pfxDest !== null && file_exists($pfxDest)) {
                $info['pfxFile'] = $pfxDest;
                $info['pfxExists'] = true;
                $info['pfxAge'] ??= filemtime($pfxDest);
            }
        }

        return $info;
    }

    public function renew(string $domain, ?string $email = null): array
    {
        if (!self::canRunAcme()) {
            $reason = self::isWindows()
                ? 'acme.sh requiere Linux. Esta función solo funciona en el servidor de producción.'
                : 'acme.sh no puede emitir certificados para localhost.';

            return ['success' => false, 'log' => [], 'error' => $reason];
        }

        $acmeHome = $this->getAcmeHome();
        $acmeSh = $acmeHome . '/acme.sh';
        $email ??= $this->getEmail();
        $webroot = $this->getWebroot();
        $pfxPass = $this->getPfxPassword();
        $pfxDest = $this->getPfxDestination();

        $log = [];

        if (!$this->isAcmeInstalled()) {
            return ['success' => false, 'log' => [], 'error' => 'acme.sh no está instalado. Instálalo manualmente vía SSH con: curl -sL https://get.acme.sh | sh'];
        }

        $log[] = 'acme.sh ya instalado.';

        // Set CA (Let's Encrypt or ZeroSSL)
        $ca = Configure::read('SSLGeneration.ca') ?? 'letsencrypt';
        $this->execCmd([$acmeSh, '--home', $acmeHome, '--set-default-ca', '--server', $ca], $o, $c);
        $log[] = 'CA configurada: ' . $ca;

        // Determine DNS provider
        $dnsProvider = Configure::read('SSLGeneration.dnsProvider') ?? 'webroot';

        // Issue/renew
        $log[] = "Renovando certificado para: {$domain}...";
        $log[] = 'Método DNS: ' . $dnsProvider;

        if ($dnsProvider === 'cpanel') {
            $this->ensureDnsApiScript($acmeHome);
            $cmd = [$acmeSh, '--home', $acmeHome, '--issue', '-d', $domain, '--dns', 'dns_cpanel', '--force', '--keylength', '2048', '--dnssleep', '5'];
        } else {
            $cmd = [$acmeSh, '--issue', '-d', $domain, '--webroot', $webroot, '--force'];
        }

        $this->execCmd($cmd, $output, $exitCode);
        $log = array_merge($log, $output);

        if ($exitCode !== 0) {
            $lastLines = array_slice(array_filter($output, fn($l) => !preg_match('/^\[(Mon|Tue|Wed|Thu|Fri|Sat|Sun) /', $l)), -10);
            $reason = 'Error al renovar certificado: ' . ($lastLines ? implode(' | ', $lastLines) : 'exit code ' . $exitCode);

            return ['success' => false, 'log' => $log, 'error' => $reason];
        }

        $log[] = 'Certificado renovado correctamente.';

        // Generate PFX
        $certDir = $acmeHome . '/' . $domain;
        $pfxFile = $certDir . '/' . $domain . '.pfx';

        $log[] = 'Generando PFX...';

        if ($pfxPass !== '') {
            $opensslCmd = sprintf(
                'openssl pkcs12 -export -out %s -inkey %s -in %s -certfile %s -passout pass:%s',
                escapeshellarg($pfxFile),
                escapeshellarg($certDir . '/' . $domain . '.key'),
                escapeshellarg($certDir . '/' . $domain . '.cer'),
                escapeshellarg($certDir . '/fullchain.cer'),
                escapeshellarg($pfxPass)
            );
        } else {
            $opensslCmd = sprintf(
                'openssl pkcs12 -export -out %s -inkey %s -in %s -certfile %s -passout pass:',
                escapeshellarg($pfxFile),
                escapeshellarg($certDir . '/' . $domain . '.key'),
                escapeshellarg($certDir . '/' . $domain . '.cer'),
                escapeshellarg($certDir . '/fullchain.cer')
            );
        }

        exec($opensslCmd . ' 2>&1', $pfxOutput, $pfxExitCode);
        $log = array_merge($log, $pfxOutput);

        if ($pfxExitCode !== 0) {
            $pfxReason = 'Error al generar PFX: ' . implode(' | ', array_slice($pfxOutput, -5));

            return ['success' => false, 'log' => $log, 'error' => $pfxReason];
        }

        $log[] = 'PFX generado: ' . $pfxFile;

        // Copy to destination
        if ($pfxDest !== null) {
            $destDir = dirname($pfxDest);
            if (!is_dir($destDir)) {
                mkdir($destDir, 0755, true);
            }
            if (copy($pfxFile, $pfxDest)) {
                $log[] = 'PFX copiado a: ' . $pfxDest;
            } else {
                $log[] = 'ERROR: No se pudo copiar PFX a: ' . $pfxDest;
            }
        }

        return ['success' => true, 'log' => $log, 'error' => null];
    }

    private function ensureDnsApiScript(string $acmeHome): void
    {
        $dnsApiDir = $acmeHome . '/dnsapi';
        $scriptPath = $dnsApiDir . '/dns_cpanel.sh';

        if (!is_dir($dnsApiDir)) {
            mkdir($dnsApiDir, 0755, true);
        }

        $cakeBin = ROOT . DS . 'bin' . DS . 'cake.php';
        $phpBin = PHP_BINARY;

        $content = sprintf(
            "#!/bin/bash\n\ndns_cpanel_add() {\n    %s %s cpanel_dns add \"\$1\" -- \"\$2\"\n}\n\ndns_cpanel_rm() {\n    %s %s cpanel_dns remove \"\$1\" -- \"\$2\"\n}\n",
            escapeshellarg($phpBin),
            escapeshellarg($cakeBin),
            escapeshellarg($phpBin),
            escapeshellarg($cakeBin)
        );

        file_put_contents($scriptPath, $content);
        chmod($scriptPath, 0755);
    }

    private function execCmd(array $args, ?array &$output = null, ?int &$exitCode = null): array
    {
        $cmd = implode(' ', array_map('escapeshellarg', $args));
        exec($cmd . ' 2>&1', $output, $exitCode);

        return $output;
    }
}
