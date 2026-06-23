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

    public function getRecordName(string $domain): string
    {
        if ($domain === $this->zone) {
            return '_acme-challenge';
        }

        $suffix = '.' . $this->zone;
        if (str_ends_with($domain, $suffix)) {
            $sub = substr($domain, 0, -strlen($suffix));

            return '_acme-challenge.' . $sub;
        }

        return '_acme-challenge.' . $domain;
    }

    public function addTxtRecord(string $domain, string $value): void
    {
        $name = $this->getRecordName($domain);
        $zoneData = $this->parseZoneWithSerial();
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
        $result = $payload['result'] ?? [];

        if (($result['status'] ?? 0) !== 1) {
            $errors = implode('; ', (array) ($result['errors'] ?? ['error desconocido']));
            throw new RuntimeException('cPanel mass_edit_zone (add) falló: ' . $errors);
        }
    }

    public function removeTxtRecord(string $domain, string $value): void
    {
        $name = $this->getRecordName($domain);
        $zoneData = $this->parseZoneWithSerial();
        $serial = $zoneData['serial'];

        foreach ($zoneData['records'] as $record) {
            if (($record['type'] ?? '') !== 'TXT') {
                continue;
            }

            $recordName = $record['dname'] ?? '';
            $recordData = $this->extractDataString($record['data'] ?? []);

            if (!str_contains($recordName, $name)) {
                continue;
            }
            if (!str_contains($recordData, $value)) {
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
            $result = $payload['result'] ?? [];

            if (($result['status'] ?? 0) !== 1) {
                $errors = implode('; ', (array) ($result['errors'] ?? ['error desconocido']));
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
        $zoneData = $this->parseZoneWithSerial();

        return $zoneData['records'];
    }

    private function parseZoneWithSerial(): array
    {
        $response = $this->rawRequest('get', '/execute/DNS/parse_zone', ['zone' => $this->zone]);
        $payload = json_decode($response->getStringBody(), true);
        $result = $payload['result'] ?? [];

        if (($result['status'] ?? 0) !== 1) {
            $errors = implode('; ', (array) ($result['errors'] ?? ['error desconocido']));
            throw new RuntimeException('cPanel parse_zone falló: ' . $errors);
        }

        $records = $result['data'] ?? [];
        $serial = 0;

        foreach ($records as $record) {
            if (($record['type'] ?? '') === 'SOA') {
                $soaData = $record['data'] ?? [];
                if (is_array($soaData) && isset($soaData[2])) {
                    $serial = (int) $soaData[2];
                }
                break;
            }
        }

        if ($serial === 0) {
            throw new RuntimeException('No se pudo determinar el serial SOA de la zona ' . $this->zone);
        }

        return ['records' => $records, 'serial' => $serial];
    }

    private function extractDataString(array $data): string
    {
        if (empty($data)) {
            return '';
        }

        return implode(' ', array_map(fn($v) => trim((string) $v, '"'), $data));
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
