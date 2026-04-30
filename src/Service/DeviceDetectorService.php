<?php
namespace SPC\Service;

use DeviceDetector\DeviceDetector;

/**
 * DeviceDetectorService
 *
 * @property \App\Model\Table\StreamHitsTable $StreamHits
 */
class DeviceDetectorService
{
    /**
     * Diccionario de aplicaciones específicas de tu negocio de streaming.
     * Si coincide aquí, no pasará por Matomo para ahorrar tiempo y 
     * asegurar el nombre exacto que deseas en tu panel.
     */
    protected array $customApps = [
        '/Echo\//i' => 'Amazon Echo (Dispositivo/Bot)',
        '/TuneIn/i' => 'TuneIn (App/Directorio)', // Cubre TuneIn-DirMon y la App
        '/RadioGarden/i' => 'Radio Garden App',
        '/Lavf/i' => 'FFmpeg / Lavf (Reproductor/Stream)',
        '/ORB HisBot/i' => 'Online Radio Box Bot',
        '/Go-http-client/i' => 'Go HTTP Client (Bot)',
        '/RadioUAS-Android/i' => 'RadioUAS Android App',
        '/RadioUAS-iOS/i' => 'RadioUAS iOS App',
        '/RadioUAS-Alexa/i' => 'RadioUAS Alexa Skill',
    ];

    /**
     * Procesa un listado de User Agents y añade una clave 'identified' con el resultado.
     *
     * @param array $userAgents
     * @return array
     */
    public function identify(array $userAgents): array
    {
        foreach ($userAgents as &$item) {
            if (isset($item['userAgent'])) {
                $item['identified'] = $this->analyzeSingle($item['userAgent']);
            }
        }

        return $userAgents;
    }

    /**
     * Analiza una cadena individual (Híbrido: Reglas propias + DeviceDetector).
     *
     * @param string $userAgent
     * @return string
     */
    protected function analyzeSingle(string $userAgent): string
    {
        // 1. PRIMERO: Buscamos en tus reglas personalizadas de radio/streaming
        foreach ($this->customApps as $regex => $name) {
            if (preg_match($regex, $userAgent)) {
                return $name;
            }
        }

        // 2. SEGUNDO: Delegamos el trabajo pesado a Matomo
        $dd = new DeviceDetector($userAgent);
        $dd->parse();

        // Verificamos si es un bot estándar (Google, Bing, Scrapers, etc.)
        if ($dd->isBot()) {
            $botInfo = $dd->getBot();
            $botName = $botInfo['name'] ?? 'Bot Desconocido';
            return $botName . ' (Bot/App)';
        }

        // Extraemos OS y Cliente
        $osInfo = $dd->getOs();
        $clientInfo = $dd->getClient();

        $osName = $osInfo['name'] ?? 'OS Desconocido';
        $osVersion = $osInfo['version'] ?? '';

        $browserName = $clientInfo['name'] ?? 'Navegador Desconocido';

        $fullOs = trim($osName . ' ' . $osVersion);

        if (empty($fullOs)) {
            $fullOs = 'OS Desconocido';
        }

        return $fullOs . ' / ' . $browserName;
    }
}