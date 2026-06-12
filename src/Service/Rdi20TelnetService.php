<?php
declare(strict_types=1);

namespace SPC\Service;

use Cake\Network\Exception\SocketException;
use Cake\Network\Socket;

class Rdi20TelnetService
{
    public const string HOST = '192.168.96.20';

    public const int PORT = 23;

    public const string USERNAME = 'user';

    public const string PASSWORD = 'pass';

    private const int TIMEOUT = 5;

    private string $lastResponse = '';

    private string $lastError = '';

    public function send(string $payload): bool
    {
        $this->lastResponse = '';
        $this->lastError = '';

        $socket = new Socket([
            'host' => self::HOST,
            'port' => self::PORT,
            'protocol' => 'tcp',
            'timeout' => self::TIMEOUT,
        ]);

        try {
            if (!$socket->connect()) {
                $this->lastError = $socket->lastError() ?? 'Conexión falló';

                return false;
            }

            $this->readUntil($socket, ['Username:', 'login:']);

            $socket->write(self::USERNAME . "\r\n");

            $this->readUntil($socket, ['Password:', 'password:']);

            $socket->write(self::PASSWORD . "\r\n");

            $result = $this->readUntil($socket, ['RDi>', '>', '#', '$']);

            if (stripos($result, 'Authentication failed') !== false || stripos($result, 'failed') !== false) {
                $this->lastError = 'Authentication failed';
                $socket->disconnect();

                return false;
            }

            $socket->write($payload);

            $response = $this->readUntil($socket, ['RDi>', '>', '#', '$'], 2);
            $this->lastResponse = $response;

            $socket->disconnect();

            $success = str_contains($response, '+');
            if (!$success) {
                $this->lastError = sprintf('RDI respondió sin "+": %s', json_encode($response));
            }

            return $success;
        } catch (SocketException $e) {
            $this->lastError = $e->getMessage();
            $socket->disconnect();

            return false;
        }
    }

    private function readUntil(Socket $socket, array $markers, int $extraTimeout = 0): string
    {
        $data = '';
        $start = microtime(true);
        $maxWait = self::TIMEOUT + $extraTimeout;

        while ((microtime(true) - $start) < $maxWait) {
            $chunk = $socket->read(4096);
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
