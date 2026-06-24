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

        $canRunAcme = $ssl->isAcmeInstalled();
        $dnsProvider = Configure::read('SSLGeneration.dnsProvider') ?? 'webroot';

        $this->set(compact('domain', 'certInfo', 'configured', 'ssl', 'canRunAcme', 'dnsProvider'));

        return $this->render();
    }

    public function download(): Response
    {
        $this->request->allowMethod(['get']);

        $type = $this->request->getQuery('type', 'pfx');
        $ssl = new SslService();
        $domain = $ssl->getDomain();

        if ($domain === null) {
            $this->Flash->error('No hay dominio configurado.');

            return $this->redirect(['action' => 'index']);
        }

        $certInfo = $ssl->getCertInfo($domain);

        if (!$certInfo['exists']) {
            $this->Flash->error('No hay certificado para descargar.');

            return $this->redirect(['action' => 'index']);
        }

        $files = [
            'pfx' => $certInfo['pfxFile'] ?? null,
            'cert' => $certInfo['certFile'] ?? null,
            'key' => $certInfo['keyFile'] ?? null,
            'fullchain' => $certInfo['fullchainFile'] ?? null,
        ];

        $file = $files[$type] ?? null;

        if ($file === null || !file_exists($file)) {
            $this->Flash->error('Archivo no encontrado.');

            return $this->redirect(['action' => 'index']);
        }

        $names = [
            'pfx' => $domain . '.pfx',
            'cert' => $domain . '.cer',
            'key' => $domain . '.key',
            'fullchain' => 'fullchain.cer',
        ];

        return $this->response->withFile($file, [
            'download' => true,
            'name' => $names[$type],
        ]);
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

        $certInfo = $ssl->getCertInfo($domain);
        $configured = $domain !== null;
        $canRunAcme = $ssl->isAcmeInstalled();
        $dnsProvider = Configure::read('SSLGeneration.dnsProvider') ?? 'webroot';

        $this->set(compact(
            'domain', 'certInfo', 'configured', 'ssl',
            'canRunAcme', 'dnsProvider'
        ));

        $this->set('renewLog', $result['log'] ?? []);

        if ($result['success']) {
            $this->Flash->success('Certificado renovado y PFX generado correctamente.');
        } else {
            $this->Flash->error('Error: ' . ($result['error'] ?? 'Error desconocido'));
        }

        return $this->render('index');
    }
}
