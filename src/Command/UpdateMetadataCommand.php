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
use SPC\Service\NowPlayingService;

class UpdateMetadataCommand extends Command
{
    private const string API_UPDATE_ENDPOINT = '/update';
    private const int REQUEST_TIMEOUT = 10;
    private const string CACHE_KEY = 'last_sent_metadata';

    /**
     * Comando para actualizar metadatos desde un cron job
     *
     * Consulta el programa actual vía NowPlayingService y lo envía
     * a /api/metadata/update para actualizar SHOUTcast.
     * Solo envía si la metadata ha cambiado desde la última ejecución.
     *
     * Uso: bin/cake update_metadata
     */
    public function execute(Arguments $args, ConsoleIo $io): int
    {
        try {
            $data = (new NowPlayingService())->get();
            $metadata = $data['produccion'] . ' - ' . $data['programa'];

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