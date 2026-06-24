<?php
declare(strict_types=1);

namespace SPC\Service;

use Cake\Core\Configure;

class SslService
{
    public function getDomain(): string
    {
        return Configure::read('SSLGeneration.domain');
    }

    public function getEmail(): string
    {
        return Configure::read('SSLGeneration.email');
    }

    public function getPfxPassword(): string
    {
        return Configure::read('SSLGeneration.pfxPassword');
    }

    public function getPfxDestination(): string
    {
        return Configure::read('SSLGeneration.pfxDestination');
    }

    public function getAcmeHome(): string
    {
        return Configure::read('SSLGeneration.acmeHome') ?? (getenv('HOME') ?: '/root') . '/.acme.sh';
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
            $info['error'] = 'No se encontró el certificado en: ' . $certFile;

            return $info;
        }

        $info['exists'] = true;
        $info['lastRenew'] = filemtime($targetFile);

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

        // PFX info
        $acmePfx = $certDir . '/' . $domain . '.pfx';
        if (file_exists($acmePfx)) {
            $info['pfxExists'] = true;
            $info['pfxAge'] = filemtime($acmePfx);
            $info['pfxFile'] = $acmePfx;
        }
        if ($pfxDest !== null && file_exists($pfxDest)) {
            $info['pfxFile'] = $pfxDest;
            $info['pfxExists'] = true;
            $info['pfxAge'] ??= filemtime($pfxDest);
        }

        return $info;
    }

    public function renew(string $domain, ?string $email = null): array
    {
        $acmeHome = $this->getAcmeHome();
        $acmeSh = $acmeHome . '/acme.sh';
        $email ??= $this->getEmail();
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
            $cmd = [$acmeSh, '--home', $acmeHome, '--issue', '-d', $domain, '--webroot', '/tmp', '--force'];
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
