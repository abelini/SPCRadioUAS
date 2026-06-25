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
        $this->set($this->_loadData());

        return $this->render();
    }

    public function download(): Response
    {
        $this->request->allowMethod(['get']);

        $type = $this->request->getQuery('type', 'pfx');
        $ssl = new SslService();
        $domain = $ssl->getDomain();
        $certInfo = $ssl->getCertInfo($domain);

        if (!$certInfo->exists) {
            $this->Flash->error('No hay certificado para descargar.');

            return $this->redirect(['action' => 'index']);
        }

        $files = [
            'pfx' => $certInfo->pfxFile ?? null,
            'cert' => $certInfo->certFile ?? null,
            'key' => $certInfo->keyFile ?? null,
            'fullchain' => $certInfo->fullchainFile ?? null,
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

        $result = $ssl->renew($domain);

        $this->set($this->_loadData());
        $this->set('renewLog', $result['log'] ?? []);

        if ($result['success']) {
            $this->Flash->success('Certificado renovado y PFX generado correctamente.');
        } else {
            $this->Flash->error('Error: ' . ($result['error'] ?? 'Error desconocido'));
        }

        return $this->render('index');
    }

    private function _loadData(): array
    {
        $ssl = new SslService();
        $domain = $ssl->getDomain();
        $certInfo = $ssl->getCertInfo($domain);
        $canRunAcme = $ssl->isAcmeInstalled();
        $dnsProvider = Configure::read('SSLGeneration.dnsProvider');
        $renewLog = [];

        return compact('ssl', 'domain', 'certInfo', 'canRunAcme', 'dnsProvider', 'renewLog');
    }
}
