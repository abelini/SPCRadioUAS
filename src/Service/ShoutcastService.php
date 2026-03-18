<?php
declare(strict_types=1);

namespace SPC\Service;

use Cake\Core\Configure;
use Cake\Http\Client;
use RuntimeException;

class ShoutcastService
{
    private const REQUEST_TIMEOUT = 5;
    private const ADMIN_ENDPOINT = '/admin.cgi';
    private string $password;
    private Client $http;

    public function __construct()
    {
        $this->password = Configure::read('SensitiveData.Shoutcast.password');

        $this->http = new Client([
            'scheme' => Configure::read('SensitiveData.Shoutcast.scheme'),
            'host' => Configure::read('SensitiveData.Shoutcast.host'),
            'port' => Configure::read('SensitiveData.Shoutcast.port'),
            'timeout' => self::REQUEST_TIMEOUT,
        ]);
    }

    /**
     * Actualiza los metadatos del stream (canción actual)
     */
    public function updateMetadata(string $text): void
    {
        $this->sendRequest(metadata: $text);
    }

    /**
     * Envía la petición HTTP al servidor SHOUTcast
     */
    private function sendRequest(string $metadata): void
    {
        $queryParams = [
            'mode' => 'updinfo',
            'pass' => $this->password,
            'song' => $metadata,
        ];

        $response = $this->http->get(self::ADMIN_ENDPOINT, $queryParams);

        if (!$response->isOk()) {
            throw new RuntimeException('Failed to connect to SHOUTcast server');
        }

        $body = $response->getStringBody();

        if (stripos($body, 'error') !== false) {
            throw new RuntimeException('SHOUTcast returned an error response');
        }
    }
}