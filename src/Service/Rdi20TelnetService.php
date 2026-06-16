<?php
declare(strict_types=1);

namespace SPC\Service;

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Log\Log;
use SPC\DTO\StreamData;

class Rdi20TelnetService
{
    private const string XPSS = 'RADIOUAS';

    private const int MAX_RT_LENGTH = 64;

    private const string CACHE_KEY = 'last_sent_rds';

    private const array PTY_FALLBACKS = [10, 12, 13, 16, 17, 19, 20];

    private RdiTelnetClient $client;

    private string $ps = self::XPSS;

    private string $rt = '';

    private int $pty = 0;

    private bool $music = false;

    private string $ptn = '';

    public function __construct()
    {
        $this->client = RdiTelnetClient::getInstance();
    }

    public function setPS(string $value): self
    {
        $this->ps = $value;

        return $this;
    }

    public function setRT(string $value): self
    {
        $this->rt = $value;

        return $this;
    }

    public function setPTY(int $value): self
    {
        $this->pty = $value;

        return $this;
    }

    public function setMusic(bool $value): self
    {
        $this->music = $value;

        return $this;
    }

    public function setPTN(string $value): self
    {
        $this->ptn = $value;

        return $this;
    }

    public function getPS(): string
    {
        return 'XPSS=' . $this->ps . "\r\n";
    }

    public function getRT(): string
    {
        return 'XTXT=' . $this->rt . "\r\n";
    }

    public function getPTY(): string
    {
        return 'XPTY=' . $this->pty . "\r\n";
    }

    public function getXFMS(): string
    {
        return 'XFMS=' . ($this->music ? '1' : '0') . "\r\n";
    }

    public function getPTN(): string
    {
        return 'XPTN="' . $this->ptn . "\"\r\n";
    }

    public function getLastResponse(): string
    {
        return $this->client->getLastResponse();
    }

    public function getLastError(): string
    {
        return $this->client->getLastError();
    }

    private function buildRadioText(string $programa): string
    {
        $search = ['á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú', 'ñ', 'Ñ', 'ü', 'Ü'];
        $replace = ['a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U', 'n', 'N', 'u', 'U'];

        return mb_strtoupper(mb_substr(str_replace($search, $replace, $programa), 0, self::MAX_RT_LENGTH));
    }

    public function fetchStatus(): array
    {
        $config = Configure::read('SensitiveData.Rdi20');

        if (!$this->client->connect()) {
            return ['connected' => false, 'error' => $this->client->getLastError()];
        }

        if (!$this->client->login($config['username'], $config['password'])) {
            $this->client->disconnect();
            return ['connected' => false, 'error' => $this->client->getLastError()];
        }

        $status = [
            'connected' => true,
            'version' => $this->sanitize($this->queryResponse("XVER?\r\n")),
            'ps' => $this->sanitize($this->queryResponse("XPSS?\r\n")),
            'rt' => $this->sanitize($this->queryResponse("XTXT?\r\n")),
            'pty' => $this->sanitize($this->queryResponse("XPTY?\r\n")),
            'xfms' => $this->sanitize($this->queryResponse("XFMS?\r\n")),
            'ptn' => $this->sanitize($this->queryResponse("XPTN?\r\n")),
            'pic' => $this->sanitize($this->queryResponse("XPIC?\r\n")),
            'idf' => $this->sanitize($this->queryResponse("XIDF?\r\n")),
        ];

        $this->client->disconnect();

        return $status;
    }

    protected function sanitize(string $value): string
    {
        return trim(str_replace('"', '', $value));
    }

    private function queryResponse(string $query): string
    {
        $cmdName = rtrim(rtrim($query, "\r\n"), '?');
        $response = $this->client->sendCommand($query);
        $lines = explode("\r\n", $response);

        foreach ($lines as $line) {
            $line = trim($line);
            if (str_starts_with($line, $cmdName . '=')) {
                return substr($line, strlen($cmdName) + 1);
            }
        }

        foreach ($lines as $line) {
            $line = trim($line);
            if ($line !== '' && $line !== 'RDi>' && $line !== '>' && !str_starts_with($line, $cmdName)) {
                return $line;
            }
        }

        return '';
    }

    public function update(StreamData $data): string
    {
        $override = Cache::read('rds_override');
        if ($override !== null) {
            if ($override['expires_at'] < time()) {
                Cache::delete('rds_override');
                $override = null;
            } else {
                $this->ps = $override['ps'] !== '' ? $override['ps'] : self::XPSS;
                $this->rt = $override['rt'] ?? '';
                $this->pty = (int) ($override['pty'] ?? 0);
                $this->music = !empty($override['music']);
                $this->ptn = $override['ptn'] ?? '';

                return sprintf('Override activo: %s', $this->send());
            }
        }

        $this->rt = $this->buildRadioText($data->programa);
        $this->ps = self::XPSS;
        $this->pty = $data->pty === 0
            ? Cache::remember('last_pty_' . md5($data->programa), fn() => self::PTY_FALLBACKS[array_rand(self::PTY_FALLBACKS)])
            : $data->pty;
        $this->music = $data->sm;
        $this->ptn = $data->ptn;

        return $this->send();
    }

    public function send(): string
    {
        $ts = date('Y-m-d H:i:s');

        $cacheValue = json_encode(['xpss' => $this->ps, 'xtxt' => $this->rt, 'pty' => $this->pty, 'xfms' => $this->music, 'ptn' => $this->ptn]);

        $lastSent = Cache::read(self::CACHE_KEY);
        if ($lastSent === $cacheValue) {
            Log::write('info', sprintf('[%s] Sin cambios, omitiendo', $ts), ['scope' => 'rds']);

            return 'Sin cambios, omitiendo';
        }

        $payloads = [
            'PS'  => $this->getPS(),
            'TXT' => $this->getRT(),
            'PTY' => $this->getPTY(),
            'FMS' => $this->getXFMS(),
            'PTN' => $this->getPTN(),
        ];

        Log::write('info', sprintf('[%s] --- RDS ---', $ts), ['scope' => 'rds']);
        foreach ($payloads as $name => $payload) {
            Log::write('info', sprintf('[%s]   %s: %s', $ts, $name, json_encode($payload, JSON_UNESCAPED_UNICODE)), ['scope' => 'rds']);
        }
        Log::write('info', sprintf('[%s]   RT:  %s', $ts, $this->rt), ['scope' => 'rds']);

        $config = Configure::read('SensitiveData.Rdi20');

        if (!$this->client->connect()) {
            Log::write('error', sprintf('[%s]   Conexión falló: %s', $ts, $this->client->getLastError()), ['scope' => 'rds']);

            return sprintf('Conexión falló: %s', $this->client->getLastError());
        }

        if (!$this->client->login($config['username'], $config['password'])) {
            Log::write('error', sprintf('[%s]   Login falló: %s', $ts, $this->client->getLastError()), ['scope' => 'rds']);
            $this->client->disconnect();

            return sprintf('Login falló: %s', $this->client->getLastError());
        }

        $success = true;

        foreach ($payloads as $name => $payload) {
            $response = $this->client->sendCommand($payload);

            if ($response === '' && $this->client->getLastError() !== 'Sin error') {
                Log::write('error', sprintf('[%s]   %s falló: %s', $ts, $name, $this->client->getLastError()), ['scope' => 'rds']);
                $success = false;
            } elseif (!str_contains($response, '+')) {
                Log::write('error', sprintf('[%s]   %s respondió sin "+": %s', $ts, $name, json_encode($response)), ['scope' => 'rds']);
                $success = false;
            } else {
                Log::write('info', sprintf('[%s]   %s enviado (+)', $ts, $name), ['scope' => 'rds']);
            }
        }

        $this->client->disconnect();

        if ($success) {
            Cache::write(self::CACHE_KEY, $cacheValue);

            return 'Enviado correctamente';
        }

        return 'Error al enviar algunos comandos';
    }
}
