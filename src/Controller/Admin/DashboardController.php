<?php
declare(strict_types=1);

namespace SPC\Controller\Admin;

use SPC\Controller\AppController;
use SPC\Model\Entity\Permiso;
use SPC\Model\Entity\TipoSolicitud;
use Cake\Http\Response;
use Cake\I18n\DateTime;
use Cake\Core\Configure;

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

        $this->set('user', $this->user);

        switch ($this->user->permisos[0]->name) {
            case Permiso::ADMINISTRATOR:
                $this->solicitudes = $this->getSolicitudesStats();
                $this->bitacoras = $this->getBitacorasStats();
                //$this->programas = $this->getProgramasStats();
                break;
            case Permiso::CAPTURISTA:
                $this->solicitudes = $this->getSolicitudesStats();
                $this->bitacoras = $this->getBitacorasStats();
                //$this->programas = $this->getProgramasStats();
                break;
            default:
        }

        $diff = $this->getDateDiffString($datetime->diff(DateTime::createFromFormat(\DateTimeInterface::ISO8601, $this->bitacoras['FirstOne']->format(\DateTimeInterface::ISO8601))));

        $this->set('bitacorasDiff', $diff);
        $this->set('solicitudes', $this->solicitudes);
        $this->set('bitacoras', $this->bitacoras);
        //$this->set('programas', $this->programas);
        $this->set('theme', isset($_COOKIE['theme']) ? $_COOKIE['theme'] : 'midday');

        $this->viewBuilder()->setTemplate($this->viewBuilder()->getLayout());
        return $this->render();
    }

    protected function getSolicitudesStats(): array
    {
        $query = $this->getTableLocator()->get('Solicitudes')->find();
        $stats = $query
            ->select([
                'Total' => $query->func()->count('*'),
                'TotalGDS' => $query->func()->count(
                    $query->expr()->case()->when(['tipoSolicitudID' => TipoSolicitud::GRABACION_DE_SPOT])->then(1)
                ),
                'TotalMDC' => $query->func()->count(
                    $query->expr()->case()->when(['tipoSolicitudID' => TipoSolicitud::MAESTRO_DE_CEREMONIA])->then(1)
                ),
                'TotalCR' => $query->func()->count(
                    $query->expr()->case()->when(['tipoSolicitudID' => TipoSolicitud::CONTROL_REMOTO])->then(1)
                ),
            ])
            ->disableHydration()
            ->all();

        return $stats->toArray()[0];
    }

    protected function getBitacorasStats(): array
    {
        $stats = $this->getTableLocator()->get('BitacoraCabina')
            ->find()
            ->select(
                function ($query) {
                    return [
                        'Total' => $query->func()->count('*'),
                        'FirstOne' => $query->func()->min('fecha', ['date']),
                        'LastOne' => $query->func()->max('fecha', ['date']),
                    ];
                }
            )
            ->orderByAsc('fecha')
            ->disableHydration()
            ->all();
        return $stats->toArray()[0];
    }

    public function getProgramsStats(): Response
    {
        $this->disableAutoRender();

        $query = $this->getTableLocator()->get('Programas')->find(admin: true);

        $stats = $query
            ->select([
                'total' => $query->func()->count('*'),
                'musical' => $query->func()->count(
                    $query->expr()->case()->when(['musical' => true, 'outOfAir' => false])->then(1)
                ),
                'spoken' => $query->func()->count(
                    $query->expr()->case()->when(['musical' => false, 'outOfAir' => false])->then(1)
                ),
                'outOfAir' => $query->func()->count(
                    $query->expr()->case()->when(['outOfAir' => true])->then(1)
                ),
            ])
            ->disableHydration()
            ->toArray();

        return $this->response->withType('json')
            ->withStringBody(json_encode([
                'total' => (int) ($stats[0]['total'] ?? 0),
                'musical' => (int) ($stats[0]['musical'] ?? 0),
                'spoken' => (int) ($stats[0]['spoken'] ?? 0),
                'outOfAir' => (int) ($stats[0]['outOfAir'] ?? 0),
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

        $count = $this->getTableLocator()->get('Solicitudes')
            ->find()
            ->where(['status' => 0])
            ->count();

        return $this->response->withType('json')
            ->withStringBody(json_encode(['pending' => $count]));
    }

    public function getOpenIncidences(): Response
    {
        $this->disableAutoRender();

        $count = $this->getTableLocator()->get('Incidencias')
            ->find()
            ->where(['closed' => 0])
            ->count();

        return $this->response->withType('json')
            ->withStringBody(json_encode(['open' => $count]));
    }

    public function cabinaRecordsToday(): Response
    {
        $this->disableAutoRender();

        $today = DateTime::now()->format('Y-m-d');
        $count = $this->getTableLocator()->get('BitacoraCabina')
            ->find()
            ->where(['fecha' => $today])
            ->count();

        return $this->response->withType('json')
            ->withStringBody(json_encode([
                'registros' => $count,
                'fecha' => $today,
            ]));
    }

    public function getNextWeekRol(): Response
    {
        $this->disableAutoRender();

        $timezone = new \DateTimeZone(Configure::read('App.defaultTimezone'));
        $nextMonday = (new DateTime(timezone: $timezone))->next(DateTime::MONDAY);
        $nextSunday = (clone $nextMonday)->addDays(6);

        $count = $this->getTableLocator()->get('Roles')
            ->find()
            ->where([
                'fechaInicio' => $nextMonday->format('Y-m-d'),
            ])
            ->count();

        return $this->response->withType('json')
            ->withStringBody(json_encode([
                'existe' => $count > 0,
                'semanaInicio' => (new \IntlDateFormatter('es_MX', \IntlDateFormatter::LONG, \IntlDateFormatter::NONE, $timezone))->format($nextMonday),
                'semanaFin' => (new \IntlDateFormatter('es_MX', \IntlDateFormatter::LONG, \IntlDateFormatter::NONE, $timezone))->format($nextSunday),
                'totalLocutores' => $count,
            ]));
    }
}