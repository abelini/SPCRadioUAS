<?php

declare(strict_types=1);

namespace SPC\Service;

use Gemini;
use Gemini\Client;
use Cake\Core\Configure;
use Cake\Log\Log;
use Exception;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\Psr18Client;

class GeminiService
{
    protected Client $engine;
    protected string $APIKey;
    protected array $models = [
        'gemini-3.7-flash',
        'gemini-3.6-flash',
        'gemini-3.5-flash',
        'gemini-3.5-flash-lite',
        'gemini-3.1-flash-lite',
        'gemini-2.5-flash-lite',
        'gemini-flash-latest',
        'gemini-flash-lite-latest',
        'gemini-pro-latest',
        'gemini-3-flash-preview'
    ];

    public function __construct()
    {
        $this->APIKey = Configure::read('SensitiveData.Gemini.APIKey');
        $this->engine = Gemini::factory()
            ->withApiKey($this->APIKey)
            ->withHttpClient(new Psr18Client(HttpClient::create([
                'timeout' => 60,
                'max_duration' => 90,
            ])))
            ->make();
    }

    public function generateText(string $prompt, string $model = 'gemini-3.8-flash'): string
    {
        $models = array_merge([$model], $this->models);
        $count = count($models);

        foreach ($models as $index => $model) {
            $maxRetries = 2;
            $retryCount = 0;
            $waitTime = 2;
            $causa = '';

            while ($retryCount < $maxRetries) {
                try {
                    $result = $this->engine->generativeModel(model: $model)->generateContent($prompt);
                    return $result->text() . '<br><br><br><p class="generated-footnote">Generado con el modelo: ' . $model . '</p>';

                } catch (Exception $e) {
                    $causa = $this->classifyError($e->getMessage());

                    if ($causa === 'error') {
                        Log::error("Error crítico en Gemini ($model): " . $e->getMessage());
                        break;
                    }

                    $retryCount++;
                    if ($retryCount < $maxRetries) {
                        sleep($waitTime);
                        $waitTime *= 2;
                        continue;
                    }
                }
            }

            if ($index + 1 < $count) {
                $siguiente = $models[$index + 1];
                Log::warning("Gemini ($model) falló por $causa. Cambiando de modelo a $siguiente.");
            }
        }

        Log::error('Todos los modelos de Gemini fallaron para el prompt: ' . $prompt);
        return 'Todos los modelos fallaron...';
    }

    /**
     * Clasifica la causa del error de la API de Gemini.
     *
     * @param string $message Mensaje de la excepción.
     * @return string Causa: 'cuota', 'timeout' o 'error'.
     */
    private function classifyError(string $message): string
    {
        if (str_contains($message, 'quota') || str_contains($message, '429')) {
            return 'cuota';
        }

        if (str_contains($message, 'Idle timeout') || str_contains($message, 'timed out')) {
            return 'timeout';
        }

        return 'error';
    }
}
