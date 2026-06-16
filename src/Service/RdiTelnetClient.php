<?php
declare(strict_types=1);

namespace SPC\Service;

use Cake\Core\Configure;
use Cake\Network\Exception\SocketException;
use Cake\Network\Socket;

class RdiTelnetClient
{
    private const int TIMEOUT = 5;

    private static ?self $instance = null;

    private Socket $socket;

    private string $lastResponse = '';

    private string $lastError = '';

    private bool $connected = false;

    private bool $loggedIn = false;

    private function __construct(Socket $socket)
    {
        $this->socket = $socket;
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            $config = Configure::read('SensitiveData.Rdi20');
            $ip = gethostbyname(gethostname());
            $host = str_starts_with($ip, '192.168.') ? $config['local_host'] : $config['remote_host'];

            self::$instance = new self(new Socket([
                'host' => $host,
                'port' => $config['port'],
                'protocol' => 'tcp',
                'timeout' => self::TIMEOUT,
            ]));
        }

        return self::$instance;
    }

    public static function resetInstance(): void
    {
        self::$instance = null;
    }

    public function connect(): bool
    {
        $this->lastResponse = '';
        $this->lastError = '';

        try {
            if (!$this->socket->connect()) {
                $this->lastError = $this->socket->lastError() ?? 'Conexión falló';

                return false;
            }

            $this->connected = true;

            return true;
        } catch (SocketException $e) {
            $this->lastError = $e->getMessage();

            return false;
        }
    }

    public function login(string $username, string $password): bool
    {
        if (!$this->connected) {
            $this->lastError = 'No hay conexión';

            return false;
        }

        $this->lastResponse = '';
        $this->lastError = '';

        try {
            $this->readUntil(['Username:', 'login:']);

            $this->socket->write($username . "\r\n");

            $this->readUntil(['Password:', 'password:']);

            $this->socket->write($password . "\r\n");

            $result = $this->readUntil(['RDi>', '>', '#', '$']);

            if (stripos($result, 'Authentication failed') !== false || stripos($result, 'failed') !== false) {
                $this->lastError = 'Authentication failed';

                return false;
            }

            $this->loggedIn = true;

            return true;
        } catch (SocketException $e) {
            $this->lastError = $e->getMessage();

            return false;
        }
    }

    public function sendCommand(string $payload): string
    {
        $this->lastResponse = '';
        $this->lastError = '';

        if (!$this->connected || !$this->loggedIn) {
            $this->lastError = 'No hay conexión o no autenticado';

            return '';
        }

        try {
            $this->socket->write($payload);

            $response = $this->readUntil(['RDi>', '>', '#', '$'], 2);
            $this->lastResponse = $response;

            return $response;
        } catch (SocketException $e) {
            $this->lastError = $e->getMessage();

            return '';
        }
    }

    public function disconnect(): void
    {
        try {
            $this->socket->disconnect();
        } catch (SocketException) {
        }

        $this->connected = false;
        $this->loggedIn = false;
    }

    public function isConnected(): bool
    {
        return $this->connected;
    }

    public function isLoggedIn(): bool
    {
        return $this->loggedIn;
    }

    public function getLastResponse(): string
    {
        return $this->lastResponse;
    }

    public function getLastError(): string
    {
        return $this->lastError ?: 'Sin error';
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
}
