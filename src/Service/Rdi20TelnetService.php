<?php
declare(strict_types=1);

namespace SPC\Service;

use Cake\Core\Configure;
use Cake\Network\Exception\SocketException;
use Cake\Network\Socket;


class Rdi20TelnetService
{
    private const string LOCAL_RDI_ADDRESS = '192.168.96.20';

    private const string REMOTE_RDI_ADDRESS = '201.120.209.75';

    private const string SPC_ADDRESS = '192.250.227.56';

    private const int PORT = 2300;

    private const string USERNAME = 'user';

    private const string PASSWORD = 'pass';

    private const int TIMEOUT = 5;

    private string $lastResponse;

    private string $lastError;

    private string $host;

    private Socket $socket;

    public function __construct() {
        $ip = gethostbyname(gethostname());
        if (str_starts_with($ip, '192.168.')) {
            $this->host = self::LOCAL_RDI_ADDRESS;
        } else {
            $this->host = self::REMOTE_RDI_ADDRESS;
        }
        $this->socket = new Socket([
            'host' => $this->host,
            'port' => self::PORT,
            'protocol' => 'tcp',
            'timeout' => self::TIMEOUT,
        ]);
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function getPort(): int
    {
        return self::PORT;
    }

    public function send(string $payload): bool
    {
        $this->lastResponse = '';
        $this->lastError = '';

        try {
            if (!$this->socket->connect()) {
                $this->lastError = $socket->lastError() ?? 'Conexión falló';

                return false;
            }

            $this->readUntil(['Username:', 'login:']);

            $this->socket->write(self::USERNAME . "\r\n");

            $this->readUntil(['Password:', 'password:']);

            $this->socket->write(self::PASSWORD . "\r\n");

            $result = $this->readUntil(['RDi>', '>', '#', '$']);

            if (stripos($result, 'Authentication failed') !== false || stripos($result, 'failed') !== false) {
                $this->lastError = 'Authentication failed';
                $this->socket->disconnect();

                return false;
            }

            $this->socket->write($payload);

            $response = $this->readUntil(['RDi>', '>', '#', '$'], 2);
            $this->lastResponse = $response;

            $this->socket->disconnect();

            $success = str_contains($response, '+');
            if (!$success) {
                $this->lastError = sprintf('RDI respondió sin "+": %s', json_encode($response));
            }

            return $success;
        } catch (SocketException $e) {
            $this->lastError = $e->getMessage();
            $this->socket->disconnect();

            return false;
        }
    }

    private function readUntil(array $markers, int $extraTimeout = 0): string
    {
        $data = '';
        $start = microtime(true);
        $maxWait = self::TIMEOUT + $extraTimeout;

        while ((microtime(true) - $start) < $maxWait) {
            $chunk = $this->socket->read(4096);
            if ($chunk === null || $chunk === '') {
                if ($data !== '') {
                    usleep(100000);
                }
                break;
            }
            $data .= $chunk;

            foreach ($markers as $marker) {
                if (str_contains($data, $marker)) {
                    return $data;
                }
            }
        }

        return $data;
    }

    public function getLastResponse(): string
    {
        return $this->lastResponse;
    }

    public function getLastError(): string
    {
        return $this->lastError ?: 'Sin error';
    }
}
