<?php
declare(strict_types=1);

namespace SPC\Controller\Admin;

use Cake\Core\Configure;
use Cake\Http\Response;
use SPC\Controller\AppController;
use SPC\Service\SslService;

class SslController extends AppController
{
    public function index(): Response
    {
        $ssl = new SslService();
        $domain = $ssl->getDomain();
        $configured = $domain !== null;

        $certInfo = $configured ? $ssl->getCertInfo($domain) : null;

        $canRunAcme = SslService::canRunAcme();
        $isWindows = SslService::isWindows();
        $dnsProvider = Configure::read('SSLGeneration.dnsProvider') ?? 'webroot';

        $this->set(compact('domain', 'certInfo', 'configured', 'ssl', 'canRunAcme', 'isWindows', 'dnsProvider'));

        return $this->render();
    }

    public function renew(): ?Response
    {
        $this->request->allowMethod(['post']);

        $ssl = new SslService();
        $domain = $ssl->getDomain();

        if ($domain === null) {
            $this->Flash->error('No hay dominio configurado en SSLGeneration.domain');

            return $this->redirect(['action' => 'index']);
        }

        $result = $ssl->renew($domain);

        if ($result['success']) {
            $this->Flash->success('Certificado renovado y PFX generado correctamente.');
        } else {
            $this->Flash->error('Error: ' . ($result['error'] ?? 'Error desconocido'));
            $this->getRequest()->getSession()->write('SslRenewLog', $result['log'] ?? []);
        }

        return $this->redirect(['action' => 'index']);
    }
}
