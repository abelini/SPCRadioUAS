<?php
declare(strict_types=1);

namespace SPC\Service;

use Cake\Core\Configure;
use Cake\Http\Client;
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

    public function addTxtRecord(string $domain, string $value): bool
    {
        $name = $this->getRecordName($domain);

        $response = $this->rawRequest('post', '/execute/DNS/add_zone_record', [
            'domain' => $this->zone,
            'name' => $name,
            'type' => 'TXT',
            'address' => $value,
            'ttl' => 120,
        ]);

        $payload = json_decode($response->getStringBody(), true);

        if (!is_array($payload)) {
            Log::write('error', 'cPanel add_zone_record: respuesta inválida', ['scope' => 'ssl']);

            return false;
        }

        return ($payload['status'] ?? 0) === 1;
    }

    public function removeTxtRecord(string $domain, string $value): bool
    {
        $name = $this->getRecordName($domain);
        $records = $this->listRecords();

        foreach ($records as $record) {
            $recordName = $record['dname'] ?? $record['name'] ?? '';
            $recordValue = $record['txtdata'] ?? $record['address'] ?? '';

            if (!str_contains($recordName, $name)) {
                continue;
            }
            if (!str_contains($recordValue, $value)) {
                continue;
            }

            $lineIndex = $record['line_index'] ?? $record['Line'] ?? null;
            if ($lineIndex === null) {
                continue;
            }

            $response = $this->rawRequest('post', '/execute/DNS/remove_zone_record', [
                'domain' => $this->zone,
                'line_index' => $lineIndex,
            ]);

            $payload = json_decode($response->getStringBody(), true);

            if (!is_array($payload)) {
                Log::write('error', 'cPanel remove_zone_record: respuesta inválida', ['scope' => 'ssl']);

                return false;
            }

            return ($payload['status'] ?? 0) === 1;
        }

        Log::write('warning', sprintf(
            'cPanel remove: no se encontró record TXT con name=%s value=%s',
            $name,
            $value
        ), ['scope' => 'ssl']);

        return false;
    }

    public function listRecords(): array
    {
        $response = $this->rawRequest('get', '/execute/DNS/parse_zone', ['domain' => $this->zone]);
        $payload = json_decode($response->getStringBody(), true);

        if (!is_array($payload) || ($payload['status'] ?? 0) !== 1) {
            return [];
        }

        return $payload['data'] ?? [];
    }

    private function rawRequest(string $method, string $endpoint, array $params = []): \Cake\Http\Client\Response
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
