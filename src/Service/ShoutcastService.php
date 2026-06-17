<?php
declare(strict_types=1);

namespace SPC\Service;

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Http\Client;
use Cake\Log\Log;
use RuntimeException;
use SPC\DTO\StreamData;

class ShoutcastService
{
    private const string CACHE_KEY = 'last_sent_metadata';

    private const int REQUEST_TIMEOUT = 5;

    private const string ADMIN_ENDPOINT = '/admin.cgi';

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

    public function update(StreamData $data): string
    {
        $text = $data->produccion . ' - ' . $data->programa;
        $ts = date('Y-m-d H:i:s');

        $lastSent = Cache::read(self::CACHE_KEY);
        if ($lastSent === $text) {
            return 'Sin cambios, omitiendo';
        }

        try {
            $this->sendRequest($text);
            Cache::write(self::CACHE_KEY, $text);

            return sprintf('Actualizado: %s', $text);
        } catch (RuntimeException $e) {
            Log::write('error', sprintf('[%s] Error: %s', $ts, $e->getMessage()), ['scope' => 'shoutcast']);

            return sprintf('Error: %s', $e->getMessage());
        }
    }

    public function sendRequest(string $metadata): void
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
