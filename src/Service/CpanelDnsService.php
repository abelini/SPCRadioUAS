<?php
declare(strict_types=1);

namespace SPC\Service;

use Cake\Core\Configure;
use Cake\Http\Client;
use Cake\Http\Client\Response;
use Cake\Log\Log;
use RuntimeException;

class CpanelDnsService
{
    private const int REQUEST_TIMEOUT = 30;

    private string $baseUrl;
    private string $username;
    private string $apiToken;
    private string $zone;
    private Client $http;

    public function __construct()
    {
        $prefix = 'SSLGeneration.cpanel';

        $this->baseUrl = rtrim(
            Configure::read($prefix . '.baseUrl')
            ?? throw new RuntimeException('cPanel baseUrl no configurado en SSLGeneration.cpanel.baseUrl'),
            '/'
        );
        $this->username = Configure::read($prefix . '.username')
            ?? throw new RuntimeException('cPanel username no configurado en SSLGeneration.cpanel.username');
        $this->apiToken = Configure::read($prefix . '.apiToken')
            ?? throw new RuntimeException('cPanel apiToken no configurado en SSLGeneration.cpanel.apiToken');
        $this->zone = Configure::read($prefix . '.zone')
            ?? throw new RuntimeException('cPanel zone no configurado en SSLGeneration.cpanel.zone');

        $this->http = new Client(['timeout' => self::REQUEST_TIMEOUT]);
    }

    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getZone(): string
    {
        return $this->zone;
    }

    private function recordName(string $domain): string
    {
        if (str_starts_with($domain, '_acme-challenge.')) {
            return $domain;
        }

        if ($domain === $this->zone) {
            return '_acme-challenge.' . $this->zone;
        }

        $suffix = '.' . $this->zone;
        if (str_ends_with($domain, $suffix)) {
            $sub = substr($domain, 0, -strlen($suffix));

            return '_acme-challenge.' . $sub . '.' . $this->zone;
        }

        return '_acme-challenge.' . $domain;
    }

    public function addTxtRecord(string $domain, string $value): void
    {
        $name = $this->recordName($domain);
        $zoneData = $this->fetchZoneData();
        $serial = $zoneData['serial'];

        $record = [[
            'dname' => $name,
            'ttl' => 120,
            'record_type' => 'TXT',
            'data' => [$value],
        ]];

        $response = $this->rawRequest('get', '/execute/DNS/mass_edit_zone', [
            'serial' => $serial,
            'zone' => $this->zone,
            'add' => json_encode($record),
        ]);

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

            if (!str_contains($recordName, $name)) {
                continue;
            }
            if ($recordData !== $value) {
                continue;
            }

            $lineIndex = $record['line_index'] ?? null;
            if ($lineIndex === null) {
                continue;
            }

            $response = $this->rawRequest('get', '/execute/DNS/mass_edit_zone', [
                'serial' => $serial,
                'zone' => $this->zone,
                'remove' => json_encode([$lineIndex]),
            ]);

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
        $response = $this->rawRequest('get', '/execute/DNS/parse_zone', ['zone' => $this->zone]);
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

    private function rawRequest(string $method, string $endpoint, array $params = []): Response
    {
        $url = $this->baseUrl . $endpoint;
        $headers = [
            'Authorization' => 'cpanel ' . $this->username . ':' . $this->apiToken,
        ];

        try {
            if ($method === 'get') {
                $response = $this->http->get($url, $params, ['headers' => $headers, 'timeout' => self::REQUEST_TIMEOUT]);
            } else {
                $response = $this->http->post($url, $params, ['headers' => $headers, 'timeout' => self::REQUEST_TIMEOUT]);
            }
        } catch (\Exception $e) {
            Log::write('error', sprintf('cPanel DNS API error: %s', $e->getMessage()), ['scope' => 'ssl']);
            throw new RuntimeException('Error de conexión con cPanel: ' . $e->getMessage());
        }

        if ($response->getStatusCode() >= 400) {
            $body = $response->getStringBody();
            Log::write('error', sprintf('cPanel DNS API HTTP %d: %s', $response->getStatusCode(), $body), ['scope' => 'ssl']);
            throw new RuntimeException(sprintf('cPanel API respondió con HTTP %d', $response->getStatusCode()));
        }

        return $response;
    }
}
