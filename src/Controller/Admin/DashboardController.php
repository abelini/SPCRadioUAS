<?php
declare(strict_types=1);

namespace SPC\Controller\Admin;

use SPC\Controller\AppController;
use SPC\Model\Entity\Permiso;
use Cake\Http\Response;
use Cake\I18n\DateTime;
use Cake\I18n\Date;


/**
 * Dashboard Controller
 */
class DashboardController extends AppController
{
    protected array $solicitudes;
    protected array $bitacoras;
    //protected array $programas;
    private const int DEFAULT_BACK_DAYS = 7;

    public function index(): Response
    {
        $datetime = parent::$datetime;

        switch ($this->user->permisos[0]->name) {
            case Permiso::ADMINISTRATOR:
                $this->solicitudes = $this->getSolicitudesStats();
                //$this->bitacoras = $this->getBitacorasStats();
                //$this->programas = $this->getProgramasStats();
                break;
            case Permiso::CAPTURISTA:
                $this->solicitudes = $this->getSolicitudesStats();
                //$this->bitacoras = $this->getBitacorasStats();
                //$this->programas = $this->getProgramasStats();
                break;
            default:
        }

        //$diff = $this->getDateDiffString($datetime->diff(DateTime::createFromFormat(\DateTimeInterface::ISO8601, $this->bitacoras['Oldest']->format(\DateTimeInterface::ISO8601))));

        //$this->set('bitacorasDiff', $diff);
        $this->set('solicitudes', $this->solicitudes);
        //$this->set('bitacoras', $this->bitacoras);
        //$this->set('programas', $this->programas);
        $this->set('theme', isset($_COOKIE['theme']) ? $_COOKIE['theme'] : 'midday');

        $this->viewBuilder()->setTemplate($this->viewBuilder()->getLayout());
        return $this->render();
    }

    public function getSolicitudesStats(): array
    {
        $stats = $this->getTableLocator()->get('Solicitudes')->find('stats')->all()->toArray()[0];
        return $stats;
    }

    public function getBitacorasStats(): Response
    {
        Date::setJsonEncodeFormat("d 'de' MMMM 'del' YYYY");
        $this->disableAutoRender();
        $stats = $this->getTableLocator()->get('BitacoraCabina')->find('stats')->all()->toArray()[0];

        return $this->response->withType('json')
            ->withStringBody(json_encode($stats));
    }

    public function getProgramsStats(): Response
    {
        $this->disableAutoRender();

        $stats = $this->getTableLocator()->get('Programas')->find('stats', admin: true)->all()->toArray()[0];

        return $this->response->withType('json')
            ->withStringBody(json_encode([
                'total' => (int) ($stats['total'] ?? 0),
                'musical' => (int) ($stats['musical'] ?? 0),
                'spoken' => (int) ($stats['spoken'] ?? 0),
                'outOfAir' => (int) ($stats['outOfAir'] ?? 0),
            ]));
    }

    protected function getDateDiffString(\DateInterval $diff): string
    {
        return $diff->y . ' años, ' . $diff->m . ' meses y ' . $diff->d . ' días';
    }

    public function streamingStats(): Response
    {
        $this->disableAutoRender();

        $from = new DateTime()->subDays(self::DEFAULT_BACK_DAYS)->setTime(0, 0, 0);
        $to = new DateTime()->setTime(23, 59, 59);

        $data = $this->getTableLocator()->get('StreamHits')
            ->getSummaryStats($from, $to, ['totalHits', 'hitsToday', 'maxDay']);

        return $this->response->withType('json')
            ->withStringBody(json_encode([
                'totalListeners' => $data['totalHits'] ?? 0,
                'hitsToday' => $data['hitsToday'] ?? 0,
                'maxDay' => $data['maxDay'] ?? null,
            ]));
    }

    public function getPendingRequests(): Response
    {
        $this->disableAutoRender();

        $count = $this->getTableLocator()->get('Solicitudes')->find('pending')->count();

        return $this->response->withType('json')
            ->withStringBody(json_encode(['pending' => $count]));
    }

    public function getOpenIncidences(): Response
    {
        $this->disableAutoRender();

        $count = $this->getTableLocator()->get('Incidencias')->find('open')->count();

        return $this->response->withType('json')
            ->withStringBody(json_encode(['open' => $count]));
    }

    public function getNextWeekRol(): Response
    {
        $this->disableAutoRender();

        $nextMonday = new Date()->next(DateTime::MONDAY);
        $nextSunday = (clone $nextMonday)->addDays(6);

        $rol = $this->getTableLocator()->get('Roles')->find('next', date: $nextMonday)->first();

        if ($rol === null) {
            return $this->response->withType('json')
                ->withStringBody(json_encode([
                    'existe' => false,
                ]));
        }

        return $this->response->withType('json')
            ->withStringBody(json_encode([
                'existe' => true,
                'semanaInicio' => $nextMonday->i18nFormat("d' de 'MMMM' del 'YYYY"),
                'semanaFin' => $nextSunday->i18nFormat("d' de 'MMMM' del 'YYYY"),
                'rolID' => $rol->ID,
            ]));
    }
}