<?php
declare(strict_types=1);

namespace SPC\Service;

use Cake\Core\Configure;
use Cake\Http\Client;
use RuntimeException;

class CpanelDnsService
{
    private const int REQUEST_TIMEOUT = 30;

    private string $username;

    private string $apiToken;

    private string $zone;

    private Client $http;

    public function __construct()
    {
        $this->username = Configure::read('SSLGeneration.cpanel.username');
        $this->apiToken = Configure::read('SSLGeneration.cpanel.apiToken');
        $this->zone = Configure::read('SSLGeneration.cpanel.zone');

        $this->http = new Client([
            'scheme' => 'https',
            'host' => 'radiouas.org',
            'port' => 2083,
            'basePath' => '/execute',
            'timeout' => self::REQUEST_TIMEOUT,
            'headers' => [
                'Authorization' => 'cpanel ' . $this->username . ':' . $this->apiToken,
            ]
        ]);
    }

    public function getZone(): string
    {
        return $this->zone;
    }

    public function getBaseUrl(): string
    {
        return 'https://radiouas.org:2083';
    }

    private function recordName(string $domain): string
    {
        if (str_starts_with($domain, '_acme-challenge.')) {
            return rtrim($domain, '.') . '.';
        }

        if ($domain === $this->zone) {
            return '_acme-challenge.' . $this->zone . '.';
        }

        $suffix = '.' . $this->zone;
        if (str_ends_with($domain, $suffix)) {
            $sub = substr($domain, 0, -strlen($suffix));

            return '_acme-challenge.' . $sub . '.' . $this->zone . '.';
        }

        return '_acme-challenge.' . $domain . '.';
    }

    public function addTxtRecord(string $domain, string $value): void
    {
        $name = $this->recordName($domain);
        $zoneData = $this->fetchZoneData();
        $serial = $zoneData['serial'];

        // Purge existing acme-challenge records for this domain
        foreach ($zoneData['records'] as $record) {
            if (($record['record_type'] ?? '') !== 'TXT') {
                continue;
            }
            $recordName = $record['dname_raw'] ?? '';
            if (!str_contains($recordName, $domain)) {
                continue;
            }
            $lineIndex = $record['line_index'] ?? null;
            if ($lineIndex === null) {
                continue;
            }

            $response = $this->http->get('/DNS/mass_edit_zone', [
                'serial' => $serial,
                'zone' => $this->zone,
                'remove' => $lineIndex,
            ]);

            if ($response->getStatusCode() >= 400) {
                throw new RuntimeException('cPanel API respondió con HTTP ' . $response->getStatusCode());
            }

            $payload = json_decode($response->getStringBody(), true);

            if (($payload['status'] ?? 0) !== 1) {
                $errors = implode('; ', (array) ($payload['errors'] ?? ['error desconocido']));
                throw new RuntimeException('cPanel mass_edit_zone (remove stale) falló: ' . $errors);
            }

            $zoneData = $this->fetchZoneData();
            $serial = $zoneData['serial'];
        }

        $record = [
            'dname' => $name,
            'ttl' => 120,
            'record_type' => 'TXT',
            'data' => [$value],
        ];

        $response = $this->http->get('/DNS/mass_edit_zone', [
            'serial' => $serial,
            'zone' => $this->zone,
            'add' => json_encode($record),
        ]);

        if ($response->getStatusCode() >= 400) {
            throw new RuntimeException('cPanel API respondió con HTTP ' . $response->getStatusCode());
        }

        $payload = json_decode($response->getStringBody(), true);

        if (($payload['status'] ?? 0) !== 1) {
            $errors = implode('; ', (array) ($payload['errors'] ?? ['error desconocido']));
            throw new RuntimeException('cPanel mass_edit_zone (add) falló: ' . $errors);
        }
    }

    public function removeTxtRecord(string $domain, string $value): void
    {
        $name = $this->recordName($domain);
        $zoneData = $this->fetchZoneData();
        $serial = $zoneData['serial'];

        foreach ($zoneData['records'] as $record) {
            if (($record['record_type'] ?? '') !== 'TXT') {
                continue;
            }

            $recordName = $record['dname_raw'] ?? '';
            $recordData = !empty($record['data_b64'])
                ? trim(base64_decode(str_replace(["\r", "\n"], '', $record['data_b64'][0])), '"')
                : '';

            if (!str_contains($recordName, $domain)) {
                continue;
            }
            if ($recordData !== $value) {
                continue;
            }

            $lineIndex = $record['line_index'] ?? null;
            if ($lineIndex === null) {
                continue;
            }

            $response = $this->http->get('/DNS/mass_edit_zone', [
                'serial' => $serial,
                'zone' => $this->zone,
                'remove' => $lineIndex,
            ]);

            if ($response->getStatusCode() >= 400) {
                throw new RuntimeException('cPanel API respondió con HTTP ' . $response->getStatusCode());
            }

            $payload = json_decode($response->getStringBody(), true);

            if (($payload['status'] ?? 0) !== 1) {
                $errors = implode('; ', (array) ($payload['errors'] ?? ['error desconocido']));
                throw new RuntimeException('cPanel mass_edit_zone (remove) falló: ' . $errors);
            }

            return;
        }

        throw new RuntimeException(sprintf(
            'No se encontró record TXT para eliminar (name=%s, value=%s)',
            $name,
            $value
        ));
    }

    public function listRecords(): array
    {
        $zoneData = $this->fetchZoneData();
        $decoded = [];

        foreach ($zoneData['records'] as $record) {
            $entry = [
                'type' => $record['record_type'] ?? '',
                'name' => $record['dname_raw'] ?? '',
                'ttl' => $record['ttl'] ?? 0,
                'line_index' => $record['line_index'] ?? null,
                'data' => [],
            ];

            if (!empty($record['data_b64'])) {
                foreach ($record['data_b64'] as $b64) {
                    $entry['data'][] = $this->decodeBase64Field($b64);
                }
            }

            $decoded[] = $entry;
        }

        return $decoded;
    }

    private function fetchZoneData(): array
    {
        $response = $this->http->get('/DNS/parse_zone', ['zone' => $this->zone]);

        if ($response->getStatusCode() >= 400) {
            throw new RuntimeException('cPanel API respondió con HTTP ' . $response->getStatusCode());
        }

        $payload = json_decode($response->getStringBody(), true);

        if (($payload['status'] ?? 0) !== 1) {
            $errors = implode('; ', (array) ($payload['errors'] ?? ['error desconocido']));
            throw new RuntimeException('cPanel parse_zone falló: ' . $errors);
        }

        $records = $payload['data'] ?? [];
        $serial = 0;

        foreach ($records as $record) {
            if (($record['record_type'] ?? '') === 'SOA') {
                $dataB64 = $record['data_b64'] ?? [];
                if (is_array($dataB64) && isset($dataB64[2])) {
                    $decoded = (int) $this->decodeBase64Field($dataB64[2]);
                    if ($decoded > 0) {
                        $serial = $decoded;
                    }
                }
                break;
            }
        }

        if ($serial === 0) {
            throw new RuntimeException('No se pudo determinar el serial SOA de la zona ' . $this->zone);
        }

        return ['records' => $records, 'serial' => $serial];
    }

    private function decodeBase64Field(string $b64): string
    {
        $clean = str_replace(["\r", "\n"], '', $b64);

        return base64_decode($clean, true) ?: '';
    }

}
