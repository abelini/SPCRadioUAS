<?php
declare(strict_types=1);

namespace SPC\Command;

use Cake\Cache\Cache;
use Cake\Command\Command;
use Cake\Console\Arguments;
use Cake\Console\ConsoleIo;
use Cake\Core\Configure;
use Cake\Http\Client;
use RuntimeException;

class UpdateMetadataCommand extends Command
{
    private const API_SCHEDULE_ENDPOINT = '/now';
    private const API_UPDATE_ENDPOINT = '/update';
    private const REQUEST_TIMEOUT = 10;
    private const CACHE_KEY = 'last_sent_metadata';

    /**
     * Comando para actualizar metadatos desde un cron job
     * 
     * Consulta /api/schedule/now para obtener la metadata actual
     * y la envía a /api/metadata/update para actualizar SHOUTcast
     * Solo envía si la metadata ha cambiado desde la última ejecución
     * 
     * Uso: bin/cake update_metadata
     */
    public function execute(Arguments $args, ConsoleIo $io): int
    {
        try {
            $metadata = $this->fetchCurrentMetadata($io);

            if ($metadata === null) {
                $io->info('No scheduled metadata for current time');
                return self::CODE_SUCCESS;
            }

            $io->info('Fetched metadata: ' . $metadata);

            if ($this->hasMetadataChanged($metadata, $io)) {
                $this->sendMetadataUpdate($metadata, $io);
                $this->saveLastSentMetadata($metadata);

                $io->success(sprintf('Metadata updated: %s', $metadata));
            } else {
                $io->info('Metadata unchanged, skipping update');
            }

            return self::CODE_SUCCESS;

        } catch (RuntimeException $e) {
            $io->error('Failed to update metadata: ' . $e->getMessage());
            return self::CODE_ERROR;
        }
    }

    /**
     * Consulta el endpoint para obtener la metadata programada actual
     */
    private function fetchCurrentMetadata(ConsoleIo $io): ?string
    {
        $io->info('Fetching metadata from: https://spc.radiouas.org/api/schedule/now');

        $http = new Client([
            'scheme' => 'https',
            'host' => 'spc.radiouas.org',
            'basePath' => 'api/schedule',
            'timeout' => self::REQUEST_TIMEOUT,
        ]);

        $response = $http->get(self::API_SCHEDULE_ENDPOINT);

        $io->info('Schedule response status: ' . $response->getStatusCode());

        if ($response->getStatusCode() === 404) {
            return null;
        }

        if (!$response->isOk()) {
            throw new RuntimeException(
                sprintf('Schedule API returned status %d', $response->getStatusCode())
            );
        }

        return $response->getStringBody();
    }

    /**
     * Verifica si la metadata ha cambiado desde la última vez
     */
    private function hasMetadataChanged(string $currentMetadata, ConsoleIo $io): bool
    {
        $lastSent = Cache::read(self::CACHE_KEY);

        $io->info('Last sent metadata: ' . ($lastSent ?: '(none)'));
        $io->info('Current metadata: ' . $currentMetadata);
        $io->info('Has changed: ' . ($lastSent !== $currentMetadata ? 'YES' : 'NO'));

        return $lastSent !== $currentMetadata;
    }

    /**
     * Guarda la metadata enviada en cache
     */
    private function saveLastSentMetadata(string $metadata): void
    {
        Cache::write(self::CACHE_KEY, $metadata);
    }

    /**
     * Envía la petición de actualización al API
     */
    private function sendMetadataUpdate(string $text, ConsoleIo $io): void
    {
        $token = Configure::read('SensitiveData.Shoutcast.token');

        $io->info('Token configured: ' . (empty($token) ? 'NO' : 'YES (length: ' . strlen($token) . ')'));
        $io->info('Sending POST to: https://spc.radiouas.org/api/metadata/update');
        $io->info('Payload: ' . json_encode(['text' => $text]));

        // Obtener token CSRF primero
        $httpGet = new Client([
            'scheme' => 'https',
            'host' => 'spc.radiouas.org',
            'timeout' => self::REQUEST_TIMEOUT,
        ]);

        $getResponse = $httpGet->get('/api/metadata/update');
        $csrfToken = $getResponse->getCookie('csrfToken');

        $io->info('CSRF Token: ' . ($csrfToken ? $csrfToken['value'] : 'NOT FOUND'));

        $http = new Client([
            'scheme' => 'https',
            'host' => 'spc.radiouas.org',
            'basePath' => 'api/metadata',
            'timeout' => self::REQUEST_TIMEOUT,
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
                'X-CSRF-Token' => $csrfToken ? $csrfToken['value'] : '',
            ],
        ]);

        $response = $http->post(
            self::API_UPDATE_ENDPOINT,
            json_encode(['text' => $text]),
            ['type' => 'json']
        );

        $io->info('Update response status: ' . $response->getStatusCode());
        $io->info('Update response body: ' . $response->getStringBody());

        if (!$response->isOk()) {
            throw new RuntimeException(
                sprintf('API returned status %d', $response->getStatusCode())
            );
        }

        $body = $response->getJson();

        if (!isset($body['status']) || $body['status'] !== 'success') {
            $message = $body['message'] ?? 'Unknown error';
            throw new RuntimeException($message);
        }
    }

}