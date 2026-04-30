<?php
declare(strict_types=1);

namespace SPC\Controller\Admin;

use Cake\I18n\DateTime;
use Cake\Http\Response;
use SPC\Controller\AppController;
use SPC\Service\DeviceDetectorService;

/**
 * StreamHits Controller
 *
 * @property \SPC\Model\Table\StreamHitsTable $StreamHits
 */
class StreamHitsController extends AppController
{
    /**
     * Index method
     *
     * Muestra el panel de estadísticas con resumen general, gráficas, mapa
     * y tablas de consumo por dominio, app, país y user agent.
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index(): Response
    {
        $from = $this->request->getQuery('from') ?? (new DateTime('-30 days'))->format('Y-m-d');
        $to = $this->request->getQuery('to') ?? (new DateTime())->format('Y-m-d');

        $formatLabel = ['mp3' => 'AUDIO', 'hls' => 'VIDEO', 'm3u8' => 'VIDEO'];
        $refererLabel = ['android' => 'Android', 'ios' => 'iOS'];

        $this->set(compact('from', 'to', 'formatLabel', 'refererLabel'));

        return $this->render();
    }

    /**
     * API: Summary KPIs
     */
    public function apiSummary(): Response
    {
        $this->disableAutoRender();

        $from = $this->request->getQuery('from') ?? (new DateTime('-30 days'))->format('Y-m-d');
        $to = $this->request->getQuery('to') ?? (new DateTime())->format('Y-m-d');

        $data = $this->StreamHits->getSummaryStats($from, $to);

        return $this->response->withType('json')->withStringBody(json_encode($data));
    }

    /**
     * API: Charts data
     */
    public function apiCharts(): Response
    {
        $this->disableAutoRender();

        $from = $this->request->getQuery('from') ?? (new DateTime('-30 days'))->format('Y-m-d');
        $to = $this->request->getQuery('to') ?? (new DateTime())->format('Y-m-d');

        $data = $this->StreamHits->getChartsData($from, $to);

        return $this->response->withType('json')->withStringBody(json_encode($data));
    }

    /**
     * API: Tops
     */
    public function apiTops(): Response
    {
        $this->disableAutoRender();

        $from = $this->request->getQuery('from') ?? (new DateTime('-30 days'))->format('Y-m-d');
        $to = $this->request->getQuery('to') ?? (new DateTime())->format('Y-m-d');

        $data = $this->StreamHits->getTopsData($from, $to);

        $UAFinder = new DeviceDetectorService();

        $data['topUserAgents'] = $UAFinder->identify($data['topUserAgents']);

        return $this->response->withType('json')->withStringBody(json_encode($data));
    }

    /**
     * API: GeoPoints
     */
    public function apiGeo(): Response
    {
        $this->disableAutoRender();

        $from = $this->request->getQuery('from') ?? (new DateTime('-30 days'))->format('Y-m-d');
        $to = $this->request->getQuery('to') ?? (new DateTime())->format('Y-m-d');

        $data = $this->StreamHits->getGeoData($from, $to);

        return $this->response->withType('json')->withStringBody(json_encode($data));
    }

    /**
     * API: Recent
     */
    public function apiRecent(): Response
    {
        $this->disableAutoRender();

        $limit = (int) ($this->request->getQuery('limit') ?? 20);

        $data = $this->StreamHits->getRecentData($limit);

        return $this->response->withType('json')->withStringBody(json_encode($data));
    }

    private function getOSandBrowserOrUADetails(array $userAgents): array
    {
        debug($userAgents);
        //exit;

        return $userAgents;
    }

    /**
     * View method
     *
     * @param string|null $id Stream Hit id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null): Response
    {
        $streamHit = $this->StreamHits->get($id, contain: []);
        $this->set(compact('streamHit'));

        return $this->render();
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add(): Response
    {
        $streamHit = $this->StreamHits->newEmptyEntity();
        if ($this->request->is('post')) {
            $streamHit = $this->StreamHits->patchEntity($streamHit, $this->request->getData());
            if ($this->StreamHits->save($streamHit)) {
                $this->Flash->success(__('The stream hit has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The stream hit could not be saved. Please, try again.'));
        }
        $this->set(compact('streamHit'));

        return $this->render();
    }

    /**
     * Edit method
     *
     * @param string|null $id Stream Hit id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null): Response
    {
        $streamHit = $this->StreamHits->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $streamHit = $this->StreamHits->patchEntity($streamHit, $this->request->getData());
            if ($this->StreamHits->save($streamHit)) {
                $this->Flash->success(__('The stream hit has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The stream hit could not be saved. Please, try again.'));
        }
        $this->set(compact('streamHit'));

        return $this->render();
    }

    /**
     * Delete method
     *
     * @param string|null $id Stream Hit id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null): Response
    {
        $this->request->allowMethod(['post', 'delete']);
        $streamHit = $this->StreamHits->get($id);
        if ($this->StreamHits->delete($streamHit)) {
            $this->Flash->success(__('The stream hit has been deleted.'));
        } else {
            $this->Flash->error(__('The stream hit could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
