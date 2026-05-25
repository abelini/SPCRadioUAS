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
    private const int DEFAULT_BACK_DAYS = 7;

    private DateTime $from;

    private DateTime $to;

    public function initialize(): void
    {
        parent::initialize();

        try {
            $from = $this->request->getQuery('from');
            $to = $this->request->getQuery('to');

            $this->from = $from
                ? DateTime::createFromFormat('Y-m-d', $from)->setTime(0, 0, 0, 0)
                : new DateTime()->subDays(self::DEFAULT_BACK_DAYS)->setTime(0, 0, 0, 0);
            $this->to = $to
                ? DateTime::createFromFormat('Y-m-d', $to)->setTime(23, 59, 59, 999)
                : new DateTime()->setTime(23, 59, 59, 999);
        } catch (\DateMalformedStringException $e) {
            $this->from = (new DateTime())->subDays(self::DEFAULT_BACK_DAYS)->setTime(0, 0, 0, 0);
            $this->to = DateTime::now()->setTime(23, 59, 59, 999);
        }
    }



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
        $from = $this->from;
        $to = $this->to;

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
        /*try {
            $from = DateTime::createFromFormat('Y-m-d', $this->request->getQuery('from')) ?? new DateTime()->subDays(self::DEFAULT_BACK_DAYS);
            $to = DateTime::createFromFormat('Y-m-d', $this->request->getQuery('to')) ?? DateTime::now();
        } catch (\DateMalformedStringException $e) {
            $from = (new DateTime())->subDays(self::DEFAULT_BACK_DAYS);
            $to = DateTime::now();
        }*/
        $data = $this->StreamHits->getSummaryStats($this->from, $this->to);

        return $this->response->withType('json')->withStringBody(json_encode($data));
    }

    /**
     * API: Charts data
     */
    public function apiCharts(): Response
    {
        $this->disableAutoRender();

        /*$from = DateTime::createFromFormat('Y-m-d', $this->request->getQuery('from') ?? (new DateTime('-30 days'))->format('Y-m-d'));
        $to = DateTime::createFromFormat('Y-m-d', $this->request->getQuery('to') ?? (new DateTime())->format('Y-m-d'));*/

        $data = $this->StreamHits->getChartsData($this->from, $this->to);

        return $this->response->withType('json')->withStringBody(json_encode($data));
    }

    /**
     * API: Tops
     */
    public function apiTops(): Response
    {
        $this->disableAutoRender();

        /*$from = $this->request->getQuery('from') ?? (new DateTime('-30 days'))->format('Y-m-d');
        $to = $this->request->getQuery('to') ?? (new DateTime())->format('Y-m-d');*/

        $data = $this->StreamHits->getTopsData($this->from, $this->to);

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

        /*$from = $this->request->getQuery('from') ?? (new DateTime('-30 days'))->format('Y-m-d');
        $to = $this->request->getQuery('to') ?? (new DateTime())->format('Y-m-d');*/

        $data = $this->StreamHits->getGeoData($this->from, $this->to);

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

}
