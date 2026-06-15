<?php
declare(strict_types=1);

namespace SPC\Service;

use Cake\Cache\Cache;
use Cake\Log\Log;
use Cake\Network\Exception\SocketException;
use Cake\Network\Socket;
use SPC\DTO\StreamData;

class Rdi20TelnetService
{
    private const string XPSS = 'RADIOUAS';

    private const int MAX_RT_LENGTH = 64;

    private const string CACHE_KEY = 'last_sent_rds';

    private const array PTY_FALLBACKS = [10, 12, 13, 16, 17, 19, 20];

    private const string LOCAL_RDI_ADDRESS = '192.168.96.20';

    private const string REMOTE_RDI_ADDRESS = '201.120.209.75';

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

    private function buildText(StreamData $data): string
    {
        $search = ['á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú', 'ñ', 'Ñ', 'ü', 'Ü'];
        $replace = ['a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U', 'n', 'N', 'u', 'U'];

        return mb_strtoupper(mb_substr(str_replace($search, $replace, $data->programa), 0, self::MAX_RT_LENGTH));
    }

    public function update(StreamData $data): void
    {
        $ts = date('Y-m-d H:i:s');
        $text = $this->buildText($data);

        $pty = $data->pty === 0
            ? Cache::remember('last_pty_' . md5($text), fn() => self::PTY_FALLBACKS[array_rand(self::PTY_FALLBACKS)])
            : $data->pty;

        $xpssPayload = 'XPSS=' . self::XPSS . "\r\n";
        $xtxtPayload = 'XTXT=' . $text . "\r\n";
        $ptyPayload = 'XPTY=' . $pty . "\r\n";
        $xfmsPayload = 'XFMS=' . ($data->sm ? '1' : '0') . "\r\n";
        $ptnPayload = 'XPTN="' . $data->ptn . "\"\r\n";

        $cacheValue = json_encode(['xpss' => self::XPSS, 'xtxt' => $text, 'pty' => $pty, 'xfms' => $data->sm, 'ptn' => $data->ptn]);

        $lastSent = Cache::read(self::CACHE_KEY);
        if ($lastSent === $cacheValue) {
            Log::write('info', sprintf('[%s] Sin cambios, omitiendo', $ts), ['scope' => 'rds']);

            return;
        }

        Log::write('info', sprintf('[%s] --- RDS ---', $ts), ['scope' => 'rds']);
        Log::write('info', sprintf('[%s]   TXT: %s', $ts, json_encode($xtxtPayload, JSON_UNESCAPED_UNICODE)), ['scope' => 'rds']);
        Log::write('info', sprintf('[%s]   PS:  %s', $ts, json_encode($xpssPayload, JSON_UNESCAPED_UNICODE)), ['scope' => 'rds']);
        Log::write('info', sprintf('[%s]   PTY: %s', $ts, json_encode($ptyPayload, JSON_UNESCAPED_UNICODE)), ['scope' => 'rds']);
        Log::write('info', sprintf('[%s]   FMS: %s', $ts, json_encode($xfmsPayload, JSON_UNESCAPED_UNICODE)), ['scope' => 'rds']);
        Log::write('info', sprintf('[%s]   PTN: %s', $ts, json_encode($ptnPayload, JSON_UNESCAPED_UNICODE)), ['scope' => 'rds']);
        Log::write('info', sprintf('[%s]   RT:  %s', $ts, $text), ['scope' => 'rds']);

        $success = true;

        foreach ([$xpssPayload, $xtxtPayload, $ptyPayload, $xfmsPayload, $ptnPayload] as $i => $payload) {
            $name = match ($i) {
                0 => 'XPSS',
                1 => 'XTXT',
                2 => 'XPTY',
                3 => 'XFMS',
                4 => 'XPTN',
            };

            if (!$this->send($payload)) {
                Log::write('error', sprintf('[%s]   %s falló: %s', $ts, $name, $this->getLastError()), ['scope' => 'rds']);
                $success = false;
            } else {
                Log::write('info', sprintf('[%s]   %s enviado (+)', $ts, $name), ['scope' => 'rds']);
            }
        }

        if ($success) {
            Cache::write(self::CACHE_KEY, $cacheValue);
        }

        Log::write('info', sprintf('[%s] ------------------------', $ts), ['scope' => 'rds']);
    }

    public function send(string $payload): bool
    {
        $this->lastResponse = '';
        $this->lastError = '';

        try {
            if (!$this->socket->connect()) {
                $this->lastError = $this->socket->lastError() ?? 'Conexión falló';

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
