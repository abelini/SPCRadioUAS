<?php
declare(strict_types=1);

namespace SPC\Service;

use Cake\Log\Log;
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
            Log::debug(sprintf(
                'Rdi20: connect FAILED to %s:%d — %s',
                self::HOST,
                self::PORT,
                $this->lastError,
            ));

            return false;
        }

        $this->lastBytes = $this->socket->write($payload);
        $err = $this->socket->lastError();
        if ($err) {
            $this->lastError = $err;
        }

        $this->socket->disconnect();

        Log::debug(sprintf(
            'Rdi20: send -> %s:%d | payload=%s | bytes=%d | error=%s',
            self::HOST,
            self::PORT,
            json_encode($payload, JSON_UNESCAPED_UNICODE),
            $this->lastBytes,
            $this->lastError ?: '(ninguno)',
        ));

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
