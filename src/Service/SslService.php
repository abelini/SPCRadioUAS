<?php
declare(strict_types=1);

namespace SPC\Service;

use Cake\Core\Configure;
use Cake\I18n\DateTime;
use OpenSSLCertificate;
use OpenSSLAsymmetricKey;
use SPC\Model\DTO\Certificate;

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

    public function getCertInfo(string $domain): Certificate
    {
        $acmeHome = $this->getAcmeHome();
        $certDir = $acmeHome . '/' . $domain;
        $certFile = $certDir . '/' . $domain . '.cer';
        $keyFile = $certDir . '/' . $domain . '.key';
        $fullchainFile = $certDir . '/fullchain.cer';
        $pfxDest = $this->getPfxDestination();

        $pfxPath = $certDir . '/' . $domain . '.pfx';

        if (!file_exists($certFile)) {
            return new Certificate(
                error: 'No se encontró el certificado en: ' . $certFile,
                certFile: $certFile,
                keyFile: $keyFile,
                fullchainFile: $fullchainFile,
                pfxFile: $pfxPath,
            );
        }

        $certPem = file_get_contents($certFile);
        $cert = openssl_x509_read($certPem);
        $parsed = openssl_x509_parse($cert);

        $expiry = isset($parsed['validTo_time_t'])
            ? DateTime::createFromTimestamp($parsed['validTo_time_t'])
            : null;

        $issuer = !empty($parsed['issuer'])
            ? implode(', ', array_map(
                fn(string $k, string $v): string => "$k=$v",
                array_keys($parsed['issuer']),
                $parsed['issuer'],
            ))
            : null;

        $sanText = $parsed['extensions']['subjectAltName'] ?? '';
        $sans = $sanText !== '' && preg_match_all('/DNS:([^\s,]+)/', $sanText, $m)
            ? $m[1]
            : [];

        $pfxExists = file_exists($pfxPath);
        $pfxAge = $pfxExists ? DateTime::createFromTimestamp(filemtime($pfxPath)) : null;
        $pfxFile = $pfxPath;

        if ($pfxDest !== null && file_exists($pfxDest)) {
            $pfxFile = $pfxDest;
            $pfxExists = true;
            $pfxAge ??= DateTime::createFromTimestamp(filemtime($pfxDest));
        }

        return new Certificate(
            exists: true,
            expiry: $expiry,
            daysLeft: $expiry?->diffInDays(null, false),
            issuer: $issuer,
            subject: $parsed['name'] ?? null,
            sans: $sans,
            certFile: $certFile,
            keyFile: $keyFile,
            fullchainFile: $fullchainFile,
            pfxFile: $pfxFile,
            pfxExists: $pfxExists,
            pfxAge: $pfxAge,
            lastRenew: DateTime::createFromTimestamp(filemtime($certFile)),
        );
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

        // Generate PFX with PHP OpenSSL
        $certDir = $acmeHome . '/' . $domain;
        $pfxFile = $certDir . '/' . $domain . '.pfx';

        $log[] = 'Generando PFX...';

        $cert = openssl_x509_read(file_get_contents($certDir . '/' . $domain . '.cer'));
        $key = openssl_pkey_get_private(file_get_contents($certDir . '/' . $domain . '.key'));
        $caCert = openssl_x509_read(file_get_contents($certDir . '/fullchain.cer'));

        if (!openssl_pkcs12_export_to_file($cert, $pfxFile, $key, $pfxPass, ['extracerts' => [$caCert]])) {
            return ['success' => false, 'log' => $log, 'error' => 'Error al generar PFX: ' . openssl_error_string()];
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
