<?php
declare(strict_types=1);

namespace SPC\Service;

use Cake\Log\Log;

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

        $sock = @stream_socket_client(
            sprintf('tcp://%s:%d', self::HOST, self::PORT),
            $errno,
            $errstr,
            self::TIMEOUT,
        );

        if (!$sock) {
            $this->lastError = $errstr;
            Log::debug(sprintf('Rdi20Telnet: connect FAILED — %s', $errstr));

            return false;
        }

        stream_set_timeout($sock, self::TIMEOUT);

        $banner = $this->readUntil($sock, ['Username:', 'login:']);
        Log::debug(sprintf('Rdi20Telnet: banner=%s', json_encode($banner)));

        fwrite($sock, self::USERNAME . "\r\n");

        $passPrompt = $this->readUntil($sock, ['Password:', 'password:']);
        Log::debug(sprintf('Rdi20Telnet: passPrompt=%s', json_encode($passPrompt)));

        fwrite($sock, self::PASSWORD . "\r\n");

        $result = $this->readUntil($sock, ['RDi>', '>', '#', '$']);

        if (stripos($result, 'Authentication failed') !== false || stripos($result, 'failed') !== false) {
            $this->lastError = 'Authentication failed';
            Log::debug('Rdi20Telnet: auth FAILED');
            fclose($sock);

            return false;
        }

        Log::debug(sprintf('Rdi20Telnet: login OK, sending payload=%s', json_encode($payload)));

        fwrite($sock, $payload);

        $response = $this->readUntil($sock, ['RDi>', '>', '#', '$'], 2);
        $this->lastResponse = $response;
        Log::debug(sprintf('Rdi20Telnet: response=%s', json_encode($response)));

        fclose($sock);

        $success = str_contains($response, '+');
        if (!$success) {
            $this->lastError = sprintf('RDI respondió sin "+": %s', json_encode($response));
        }

        return $success;
    }

    private function readUntil($sock, array $markers, int $extraTimeout = 0): string
    {
        $data = '';
        $start = microtime(true);
        $maxWait = self::TIMEOUT + $extraTimeout;

        while ((microtime(true) - $start) < $maxWait) {
            $chunk = @fread($sock, 4096);
            if ($chunk === false || $chunk === '') {
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
