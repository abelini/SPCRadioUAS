<?php
declare(strict_types=1);

namespace SPC\Controller\Admin;

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Http\Response;
use Cake\Network\Socket;
use SPC\Controller\AppController;
use SPC\Service\RdiTelnetClient;

class RdsController extends AppController
{
    public function index(): Response
    {
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $minutes = $data['duration_unit'] === 'hours'
                ? (int) $data['duration_value'] * 60
                : (int) $data['duration_value'];

            Cache::write('rds_override', [
                'ps' => $data['ps'],
                'rt' => $data['rt'],
                'pty' => (int) $data['pty'],
                'music' => !empty($data['music']),
                'ptn' => $data['ptn'],
                'expires_at' => time() + ($minutes * 60),
            ], $minutes * 60);

            $this->Flash->success('Override RDS aplicado por ' . $minutes . ' minutos.');

            return $this->redirect(['action' => 'index']);
        }

        if ($this->request->getQuery('cancel') !== null) {
            Cache::delete('rds_override');
            $this->Flash->success('Override RDS cancelado.');

            return $this->redirect(['action' => 'index']);
        }

        $status = $this->fetchRdsStatus();
        $override = Cache::read('rds_override');

        $this->set(compact('status', 'override'));

        return $this->render();
    }

    public function status(): Response
    {
        $this->disableAutoRender();
        $this->response = $this->response->withType('application/json');

        $status = $this->fetchRdsStatus();

        return $this->response->withStringBody(json_encode($status));
    }

    private function fetchRdsStatus(): array
    {
        $config = Configure::read('SensitiveData.Rdi20');
        $ip = gethostbyname(gethostname());
        $host = str_starts_with($ip, '192.168.') ? $config['local_host'] : $config['remote_host'];

        $socket = new Socket([
            'host' => $host,
            'port' => $config['port'],
            'protocol' => 'tcp',
            'timeout' => 5,
        ]);

        $client = new RdiTelnetClient($socket);

        if (!$client->connect()) {
            return ['connected' => false, 'error' => $client->getLastError()];
        }

        if (!$client->login($config['username'], $config['password'])) {
            $client->disconnect();
            return ['connected' => false, 'error' => $client->getLastError()];
        }

        $status = [
            'connected' => true,
            'version' => $this->queryResponse($client, "XVER?\r\n"),
            'ps' => $this->queryResponse($client, "XPSS?\r\n"),
            'rt' => $this->queryResponse($client, "XTXT?\r\n"),
            'pty' => $this->queryResponse($client, "XPTY?\r\n"),
            'xfms' => $this->queryResponse($client, "XFMS?\r\n"),
            'ptn' => $this->queryResponse($client, "XPTN?\r\n"),
        ];

        $client->disconnect();

        return $status;
    }

    private function queryResponse(RdiTelnetClient $client, string $query): string
    {
        $cmdName = rtrim(rtrim($query, "\r\n"), '?');
        $response = $client->sendCommand($query);
        $lines = explode("\r\n", $response);

        foreach ($lines as $line) {
            $line = trim($line);
            if (str_starts_with($line, $cmdName . '=')) {
                return substr($line, strlen($cmdName) + 1);
            }
        }

        foreach ($lines as $line) {
            $line = trim($line);
            if ($line !== '' && $line !== 'RDi>' && $line !== '>' && !str_starts_with($line, $cmdName)) {
                return $line;
            }
        }

        return '';
    }
}
