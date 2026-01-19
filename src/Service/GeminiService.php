<?php
namespace SPC\Service;

use Gemini;
//use Parsedown;
use Gemini\Client;
use Cake\Core\Configure;

class GeminiService
{
    protected Client $engine;
    protected string $APIKey;
    protected array $models = [
        'gemini-2.5-flash',
        'gemini-2.5-flash-lite',
        'gemini-2.0-flash',
        'gemini-2.0-flash-lite',
        'gemini-2.0-flash-exp',
        'gemini-flash-lite-latest',
        'gemini-pro-latest',
        'gemini-3-flash-preview'
    ];

    public function __construct()
    {
        $this->APIKey = Configure::read('SensitiveData.Gemini.APIKey');
        $this->engine = Gemini::client($this->APIKey);
    }

    public function generateText(string $prompt): string
    {
        foreach ($this->models as $model) {
            $maxRetries = 2;
            $retryCount = 0;
            $waitTime = 2;

            while ($retryCount < $maxRetries) {
                try {
                    $result = $this->engine->generativeModel(model: $model)->generateContent($prompt);
                    return $result->text() . '<br><br><br><p class="w3-text-light-gray">Generado con el modelo: ' . $model . '</p>';

                } catch (\Exception $e) {
                    $errorMessage = $e->getMessage();

                    if (str_contains($errorMessage, 'quota') || str_contains($errorMessage, '429')) {
                        $retryCount++;
                        if ($retryCount < $maxRetries) {
                            sleep($waitTime);
                            $waitTime *= 2;
                            continue;
                        }
                    } else {
                        \Cake\Log\Log::error("Error crítico en Gemini ($model): " . $errorMessage);
                        break;
                    }
                }
            }
            \Cake\Log\Log::warning("Cambiando de modelo a $model por exceso de cuota.");
        }
        return 'Todos los modelos fallaron...';
    }
}