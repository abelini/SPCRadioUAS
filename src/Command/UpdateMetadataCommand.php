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
            $metadata = $this->fetchCurrentMetadata();

            if ($metadata === null) {
                return self::CODE_SUCCESS;
            }

            if ($this->hasMetadataChanged($metadata)) {
                $this->sendMetadataUpdate($metadata);
                $this->saveLastSentMetadata($metadata);

                $io->success(sprintf('Metadata updated: %s', $metadata));
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
    private function fetchCurrentMetadata(): ?string
    {
        $http = new Client([
            'scheme' => 'https',
            'host' => 'spc.radiouas.org',
            'basePath' => 'api/schedule',
            'timeout' => self::REQUEST_TIMEOUT,
        ]);

        $response = $http->get(self::API_SCHEDULE_ENDPOINT);

        if ($response->getStatusCode() === 404) {
            return null;
        }

        if (!$response->isOk()) {
            throw new RuntimeException(
                sprintf('Schedule API returned status %d', $response->getStatusCode())
            );
        }

        $text = trim($response->getStringBody());

        return $text !== '' ? $text : null;
    }

    /**
     * Verifica si la metadata ha cambiado desde la última vez
     */
    private function hasMetadataChanged(string $currentMetadata): bool
    {
        $lastSent = Cache::read(self::CACHE_KEY);
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
    private function sendMetadataUpdate(string $text): void
    {
        $http = new Client([
            'scheme' => 'https',
            'host' => 'spc.radiouas.org',
            'basePath' => 'api/metadata',
            'timeout' => self::REQUEST_TIMEOUT,
            'headers' => [
                'Authorization' => 'Bearer ' . Configure::read('SensitiveData.Shoutcast.token'),
                'Content-Type' => 'application/json',
            ],
        ]);

        $response = $http->post(
            self::API_UPDATE_ENDPOINT,
            json_encode(['text' => $text]),
            ['type' => 'json']
        );

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