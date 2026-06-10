<?php
declare(strict_types=1);

namespace SPC\Service;

use Cake\Network\Socket;

class Rdi20Service
{
    public const string HOST = '192.168.96.20';

    public const int PORT = 5400;

    private const int TIMEOUT = 5;

    private Socket $socket;

    private string $lastError = '';

    private int $lastBytes = 0;

    private string $lastPayload = '';

    public function __construct()
    {
        $this->socket = new Socket();
    }

    public function send(string $payload): bool
    {
        $this->lastPayload = $payload;
        $this->lastError = '';

        $this->socket->setConfig([
            'protocol' => 'udp',
            'host' => self::HOST,
            'port' => self::PORT,
            'timeout' => self::TIMEOUT,
        ]);

        $this->socket->connect();
        if (!$this->socket->isConnected()) {
            $this->lastError = $this->socket->lastError() ?? 'No se pudo conectar';

            return false;
        }

        $this->lastBytes = $this->socket->write($payload);

        $this->socket->disconnect();

        return $this->lastBytes > 0;
    }

    public function getLastBytes(): int
    {
        return $this->lastBytes;
    }

    public function getLastError(): string
    {
        return $this->lastError ?: 'Sin error';
    }

    public function getLastPayload(): string
    {
        return $this->lastPayload;
    }
}
