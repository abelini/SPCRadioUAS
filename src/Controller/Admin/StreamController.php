<?php
declare(strict_types=1);

namespace SPC\Controller\Admin;

use SPC\Controller\AppController;
use Cake\Http\Client;
use Cake\Http\Response;
use Cake\Core\Configure;

class StreamController extends AppController
{
    protected const string STREAM_SOURCE = 'https://stream.radiouas.org/?format=hls&ref=SPCMonitor';

    protected const int SERVICE_ID = 250;

    private string $APIKey;

    public function initialize(): void
    {
        parent::initialize();
        $this->APIKey = (string) Configure::read('SensitiveData.MediaCP.APIKey');
    }

    public function index(): Response
    {
        $this->set('streamSource', self::STREAM_SOURCE);
        $this->viewBuilder()->setOption('serialize', []);
        return $this->render();
    }

    public function radio()
    {
    }

    public function proxyStop()
    {
        return $this->executeAction('stop');
    }

    public function proxyRestart()
    {
        return $this->executeAction('restart');
    }

    public function checkStreamStatus()
    {
        $this->autoRender = false;
        $this->response = $this->response->withType('application/json');

        $http = new Client(['ssl_verify_peer' => false, 'timeout' => 3]);

        try {
            $response = $http->head(self::STREAM_SOURCE);
            $status = $response->isOk() ? 'online' : 'offline';
        } catch (\Exception $e) {
            $status = 'offline';
        }

        return $this->response->withStringBody(json_encode(['status' => $status]));
    }

    private function executeAction($type)
    {
        $this->autoRender = false;
        $this->response = $this->response->withType('application/json');

        $http = new Client([
            'scheme' => 'https',
            'host' => 'stream8.mexiserver.com',
            'port' => 2020,
            'basePath' => '/api/' . self::SERVICE_ID . '/media-service/',
            'ssl_verify_peer' => false,
            'timeout' => 30,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->APIKey,
                'Accept' => 'application/json'
            ]
        ]);

        $action = ($type === 'stop') ? 'stop-service' : 'start-service';

        try {
            $response = $http->post($action);
            $json = $response->getJson();

            if ($response->isOk()) {
                if (isset($json['status']) && $json['status'] === 'error') {
                    return $this->response->withStatus(400)
                        ->withStringBody(json_encode([
                            'status' => 'error',
                            'message' => 'API Error: ' . ($json['message'] ?? 'Desconocido')
                        ]));
                }

                return $this->response->withStringBody(json_encode([
                    'status' => 'success',
                    'message' => ($type === 'stop') ? "Servicio detenido via API." : "Servicio reiniciado via API.",
                    'api_response' => $json,
                ]));
            } else {
                $statusCode = $response->getStatusCode();
                $message = 'Error desconocido';

                if ($statusCode === 401) {
                    $message = 'Error 401: API Key rechazada o permisos insuficientes.';
                } elseif ($statusCode === 404) {
                    $message = 'Error 404: No se encuentra el servicio ID 250 o la ruta API cambió.';
                }

                return $this->response->withStatus($statusCode)
                    ->withStringBody(json_encode([
                        'status' => 'error',
                        'message' => $message,
                        'raw_response' => $response->getStringBody()
                    ]));
            }

        } catch (\Exception $e) {
            return $this->response->withStatus(500)
                ->withStringBody(json_encode([
                    'status' => 'error',
                    'message' => 'Excepción de conexión: ' . $e->getMessage()
                ]));
        }
    }
}