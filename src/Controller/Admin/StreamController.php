<?php
declare(strict_types=1);

namespace SPC\Controller\Admin;

use SPC\Controller\AppController;
use Cake\Http\Client;
use Cake\Core\Configure;

class StreamController extends AppController
{

    protected const string STREAM_SOURCE = 'https://stream8.mexiserver.com:2000/hls/radiouasx/radiouasx.m3u8';

    public function index()
    {
        $this->viewBuilder()->setOption('serialize', []);
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

        $http = new Client(['ssl_verify_peer' => false, 'timeout' => 5]);

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
            'ssl_verify_peer' => false,
            'timeout' => 15,
            'redirect' => true
        ]);

        try {
            $loginResponse = $http->post('/index.php', [
                'username' => Configure::read('SensitiveData.TVStream.Username'),
                'user_password' => Configure::read('SensitiveData.TVStream.Password'),
                'language' => 'default'
            ]);

            $cookies = $loginResponse->getCookieCollection();

            if ($cookies->count() === 0) {
                throw new \Exception('Login fallido: El servidor no devolvió cookies de sesión.');
            }

            $http->setConfig('basePath', '/controller/MediaService');

            $action = ($type === 'stop') ? "/stopService/250" : "/restartService/250";

            $actionResponse = $http->get($action, options: [
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