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
use Time\Duration;

class GeminiService
{
    private const int TOTAL_BUDGET_SECONDS = 90;

    private const int ATTEMPT_TIMEOUT = 45;

    private const int ATTEMPT_MAX_DURATION = 60;

    private const int MIN_ATTEMPT_SECONDS = 5;

    protected Client $engine;

    protected string $APIKey;

    protected Duration $budget;

    protected array $models = [
        'gemini-3.5-flash-lite',
        'gemini-3.1-flash-lite',
        'gemini-2.5-flash-lite',
        'gemini-3.5-flash',
        'gemini-3.6-flash',
        'gemini-3.7-flash',
        'gemini-3.8-flash',
    ];

    public function __construct()
    {
        $this->APIKey = Configure::read('SensitiveData.Gemini.APIKey');
        $this->budget = Duration::fromSeconds(self::TOTAL_BUDGET_SECONDS);
        $this->engine = $this->createEngine(self::ATTEMPT_TIMEOUT, self::ATTEMPT_MAX_DURATION);
    }

    /**
     * Genera texto con Gemini respetando un presupuesto total de espera.
     *
     * Si el presupuesto se agota sin respuesta, devuelve el prompt original
     * para que el usuario pueda copiarlo y usarlo en un chatbot.
     *
     * @param string $prompt Instrucción para el modelo.
     * @param string $model Modelo inicial.
     * @return string Texto generado o fallback con el prompt.
     */
    public function generateText(string $prompt, string $model = 'gemini-4-hydrogen'): string
    {
        $start = hrtime(true);
        $models = array_values(array_unique(array_merge([$model], $this->models)));
        $total = count($models);

        foreach ($models as $index => $currentModel) {
            $maxRetries = 2;
            $retryCount = 0;
            $wait = Duration::fromSeconds(2);
            $causa = '';

            while ($retryCount < $maxRetries) {
                $remaining = $this->remainingBudget($start);

                if ($remaining->negative || $remaining < Duration::fromSeconds(self::MIN_ATTEMPT_SECONDS)) {
                    return $this->promptFallback($prompt);
                }

                $this->engine = $this->createEngine(
                    min(self::ATTEMPT_TIMEOUT, $remaining->seconds),
                    min(self::ATTEMPT_MAX_DURATION, $remaining->seconds),
                );

                try {
                    $result = $this->engine->generativeModel(model: $currentModel)->generateContent($prompt);

                    return
                        $result->text() .
                        '<br><br><br>' .
                        '<p class="generated-footnote">Generado con el modelo: ' . $currentModel . '</p>';
                } catch (Exception $e) {
                    $causa = $this->classifyError($e->getMessage());

                    if ($causa === 'error') {
                        Log::error("Error en Gemini ($currentModel): " . $e->getMessage());
                        break;
                    }

                    $retryCount++;
                    if ($retryCount < $maxRetries) {
                        sleep($wait->seconds);
                        $wait = $wait->multiplyBy(2);
                        continue;
                    }
                }
            }

            if ($index + 1 < $total) {
                $siguiente = $models[$index + 1];
                Log::warning("Gemini ($currentModel) falló por $causa. Cambiando de modelo a $siguiente.");
            }
        }

        return $this->promptFallback($prompt);
    }

    /**
     * Calcula el presupuesto restante desde el inicio de la generación.
     *
     * @param int $start Marca de tiempo inicial en nanosegundos (hrtime).
     * @return Duration Tiempo restante; negativo si ya se agotó.
     */
    private function remainingBudget(int $start): Duration
    {
        return $this->budget->sub(Duration::fromNanoseconds(hrtime(true) - $start));
    }

    /**
     * Construye el cliente HTTP de Gemini con timeouts acotados al presupuesto.
     *
     * @param int $timeout Timeout de inactividad en segundos.
     * @param int $maxDuration Tope total por request en segundos.
     * @return Client Cliente listo para generar contenido.
     */
    private function createEngine(int $timeout, int $maxDuration): Client
    {
        return Gemini::factory()
            ->withApiKey($this->APIKey)
            ->withHttpClient(new Psr18Client(HttpClient::create([
                'timeout' => $timeout,
                'max_duration' => $maxDuration,
            ])))
            ->make();
    }

    /**
     * Devuelve el prompt con un aviso y un botón para copiarlo.
     *
     * @param string $prompt Prompt original.
     * @return string HTML del fallback.
     */
    private function promptFallback(string $prompt): string
    {
        $escaped = htmlspecialchars($prompt, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');

        return
            '<p class="w3-panel w3-pale-yellow w3-border w3-border-amber">' .
            '<b>Gemini no respondió en ' . self::TOTAL_BUDGET_SECONDS . ' segundos.</b> ' .
            'Copia el siguiente prompt y pégalo en tu chatbot:' .
            '</p>' .
            '<textarea id="prompt-fallback-text" readonly class="w3-input w3-border" rows="12" ' .
            'style="font-family:monospace;font-size:13px;">' . $escaped . '</textarea>' .
            '<button type="button" id="copy-prompt-btn" class="w3-button w3-round w3-galaxy-blue" ' .
            'style="margin-top:8px;">' .
            '<i class="fa-regular fa-copy"></i> Copiar prompt' .
            '</button>';
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
