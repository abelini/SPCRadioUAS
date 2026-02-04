<?php
declare(strict_types=1);

namespace SPC\Controller\Admin;

use SPC\Controller\AppController;
use Cake\Http\Client;

class StreamController extends AppController
{
    // DATOS DE CONEXIÓN
    private $panelUrl = 'https://stream8.mexiserver.com:2020';
    private $streamUrl = 'https://stream8.mexiserver.com:2000/hls/radiouasx/radiouasx.m3u8';

    // TUS CREDENCIALES
    private $username = 'admin@autumn.ws';
    private $password = 'UeGMxEASgWPWq3RAkA6k';

    public function index()
    {
        $this->viewBuilder()->setOption('serialize', []);
    }

    // --- MÉTODOS AJAX ---

    public function proxyStop()
    {
        return $this->executeAction('stop');
    }

    public function proxyRestart()
    {
        return $this->executeAction('restart');
    }

    /**
     * Nuevo método para verificar si el stream ya levantó
     * Esto evita el error 404/CORS en el frontend
     */
    public function checkStreamStatus()
    {
        $this->autoRender = false;
        $this->response = $this->response->withType('application/json');

        // Timeout corto porque solo queremos "pinguear" el archivo
        $http = new Client(['ssl_verify_peer' => false, 'timeout' => 5]);

        try {
            // HEAD solo pide los encabezados (es más rápido que bajar el archivo)
            $response = $http->head($this->streamUrl);
            $status = $response->isOk() ? 'online' : 'offline';
        } catch (\Exception $e) {
            $status = 'offline';
        }

        return $this->response->withStringBody(json_encode(['status' => $status]));
    }

    // --- LÓGICA PRIVADA ---

    private function executeAction($type)
    {
        $this->autoRender = false;
        $this->response = $this->response->withType('application/json');

        $http = new Client([
            'ssl_verify_peer' => false,
            'timeout' => 15,
            'redirect' => true
        ]);

        try {
            // PASO 1: LOGIN (POST)
            $loginResponse = $http->post($this->panelUrl . '/index.php', [
                'username' => $this->username,
                'user_password' => $this->password, // Nota: usas user_password aquí
                'language' => 'default'
            ]);

            // Obtenemos la colección de cookies (incluye PHPSESSID)
            $cookies = $loginResponse->getCookieCollection();

            if ($cookies->count() === 0) {
                throw new \Exception('Login fallido: El servidor no devolvió cookies de sesión.');
            }

            // PASO 2: EJECUTAR ACCIÓN (GET con Cookies)
            $actionUrl = ($type === 'stop')
                ? "/controller/MediaService/stopService/250"
                : "/controller/MediaService/restartService/250";

            $finalUrl = $this->panelUrl . $actionUrl;

            // IMPORTANTE: Pasamos el objeto $cookies completo
            $actionResponse = $http->get($finalUrl, [], [
                'cookies' => ['PHPSESSID']
            ]);

            if ($actionResponse->isOk()) {
                return $this->response->withStringBody(json_encode([
                    'status' => 'success',
                    'message' => ($type === 'stop') ? "Servicio detenido correctamente." : "Servicio reiniciado correctamente."
                ]));
            } else {
                return $this->response->withStatus(400)
                    ->withStringBody(json_encode([
                        'status' => 'error',
                        'message' => 'Login correcto, pero error en la acción: ' . $actionResponse->getStatusCode()
                    ]));
            }

        } catch (\Exception $e) {
            return $this->response->withStatus(500)
                ->withStringBody(json_encode([
                    'status' => 'error',
                    'message' => $e->getMessage()
                ]));
        }
    }
}