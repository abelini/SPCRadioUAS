<?php
declare(strict_types=1);

namespace SPC\Service;

use Cake\Network\Socket;

class Rdi20Service
{
    private const string HOST = '192.168.96.20';

    private const int PORT = 5400;

    private const int TIMEOUT = 5;

    public function send(string $payload): bool
    {
        $socket = new Socket([
            'protocol' => 'udp',
            'host' => self::HOST,
            'port' => self::PORT,
            'timeout' => self::TIMEOUT,
        ]);

        $bytes = $socket->write($payload);
        $socket->disconnect();

        return $bytes > 0;
    }
}
