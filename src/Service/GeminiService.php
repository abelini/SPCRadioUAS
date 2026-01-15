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
        'gemini-2.5-flash-lite',
        'gemini-2.0-flash-exp',
        'gemini-2.0-flash',
        'gemini-2.0-flash-lite',
        'gemini-flash-lite-latest',
        'gemini-pro-latest',
        'gemini-3-flash-preview'
    ];

    public function __construct()
    {
        $this->APIKey = Configure::read('SensitiveData.Gemini.APIKey');
        $this->engine = Gemini::client($this->APIKey);
    }

    public function generateText(string $prompt, string $model = 'gemini-2.5-flash'): string
    {
        $models = array_merge([$model], $this->models);

        foreach ($models as $currentModel) {
            $maxRetries = 2;
            $retryCount = 0;
            $waitTime = 2;

            while ($retryCount < $maxRetries) {
                try {
                    // Intentamos generar el contenido
                    $result = $this->engine->generativeModel(model: $currentModel)->generateContent($prompt);
                    return $result->text() . '<br><br><br><p class="w3-text-light-gray">Generado con el modelo: ' . $currentModel . '</p>';

                } catch (\Exception $e) {
                    $errorMessage = $e->getMessage();

                    // Si es un error de cuota o límite de velocidad (429)
                    if (str_contains($errorMessage, 'quota') || str_contains($errorMessage, '429')) {
                        $retryCount++;
                        if ($retryCount < $maxRetries) {
                            sleep($waitTime);
                            $waitTime *= 2;
                            continue; // Reintenta con el mismo modelo
                        }
                        // Si agotamos reintentos de este modelo, el "foreach" pasará al siguiente modelo
                    } else {
                        // Si es un error distinto (ej. error de sintaxis), fallamos rápido
                        \Cake\Log\Log::error("Error crítico en Gemini ($currentModel): " . $errorMessage);
                        break;
                    }
                }
            }
            \Cake\Log\Log::warning("Cambiando de modelo a $currentModel por exceso de cuota.");
        }
        return 'Todos los modelos fallaron...';
    }
}