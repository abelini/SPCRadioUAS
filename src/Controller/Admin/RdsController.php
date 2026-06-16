<?php
declare(strict_types=1);

namespace SPC\Controller\Admin;

use Cake\Cache\Cache;
use Cake\Http\Response;
use SPC\Controller\AppController;
use SPC\Service\Rdi20TelnetService;

class RdsController extends AppController
{
    public function index(): Response
    {
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $minutes = (int) $data['duration_minutes'];

            Cache::write('rds_override', [
                'ps' => $data['ps'],
                'rt' => $data['rt'],
                'pty' => (int) $data['pty'],
                'music' => !empty($data['music']),
                'ptn' => $data['ptn'],
                'expires_at' => time() + ($minutes * 60),
            ]);

            $this->Flash->success('Override RDS aplicado por ' . $minutes . ' minutos.');

            return $this->redirect(['action' => 'index']);
        }

        if ($this->request->getQuery('cancel') !== null) {
            Cache::delete('rds_override');
            $this->Flash->success('Override RDS cancelado.');

            return $this->redirect(['action' => 'index']);
        }

        $status = new Rdi20TelnetService()->fetchStatus();
        $override = Cache::read('rds_override');
        if ($override !== null && $override['expires_at'] < time()) {
            Cache::delete('rds_override');
            $override = null;
        }

        $this->set(compact('status', 'override'));

        return $this->render();
    }

    public function status(): Response
    {
        $this->disableAutoRender();
        $this->response = $this->response->withType('application/json');

        $status = new Rdi20TelnetService()->fetchStatus();

        return $this->response->withStringBody(json_encode($status));
    }
}
