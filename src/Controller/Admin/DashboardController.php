<?php
declare(strict_types=1);

namespace SPC\Controller\Admin;

//use \DateTime as DT;
//use \DateInterval;
//use \DateTimeInterface;

use SPC\Controller\AppController;
use SPC\Model\Entity\Permiso;
use SPC\Model\Entity\TipoSolicitud;

use Cake\Collection\CollectionInterface;
use Cake\Http\Response;
use Cake\I18n\DateTime;
//use Cake\ORM\Query;

/**
 * Dashboard Controller
 *
 */
class DashboardController extends AppController
{

	protected array $solicitudes;

	protected array $bitacoras;

	protected array $programas;

	public function index(): Response
	{

		$datetime = parent::$datetime; //DateTime::now();

		$this->set('user', $this->user);
		//$this->set('time', $datetime);

		switch ($this->user->permisos[0]->name) {
			case Permiso::ADMINISTRATOR:
				$this->solicitudes = $this->getSolicitudesStats();
				$this->bitacoras = $this->getBitacorasStats();
				$this->programas = $this->getProgramasStats();
				break;
			case Permiso::CAPTURISTA:
				$this->solicitudes = $this->getSolicitudesStats();
				$this->bitacoras = $this->getBitacorasStats();
				$this->programas = $this->getProgramasStats();
				break;

			case Permiso::FONOTECARIO:
				$this->solicitudes = $this->getSolicitudesStats();
				$this->bitacoras = $this->getBitacorasStats();
				$this->programas = $this->getProgramasStats();
				break;
			default:

		}

		$diff = $this->getDateDiffString($datetime->diff(DateTime::createFromFormat(\DateTimeInterface::ISO8601, $this->bitacoras['FirstOne']->format(\DateTimeInterface::ISO8601))));

		$this->set('bitacorasDiff', $diff);
		$this->set('solicitudes', $this->solicitudes);
		$this->set('bitacoras', $this->bitacoras);
		$this->set('programas', $this->programas);

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
					$query->newExpr()->case()->when(['tipoSolicitudID' => TipoSolicitud::GRABACION_DE_SPOT])->then(1)
				),
				'TotalMDC' => $query->func()->count(
					$query->newExpr()->case()->when(['tipoSolicitudID' => TipoSolicitud::MAESTRO_DE_CEREMONIA])->then(1)
				),
				'TotalCR' => $query->func()->count(
					$query->newExpr()->case()->when(['tipoSolicitudID' => TipoSolicitud::CONTROL_REMOTO])->then(1)
				),
			])
			->disableHydration()
			->all();

		return $stats->toArray()[0];
	}

	protected function getBitacorasStats(): array
	{
		$query = $this->getTableLocator()->get('BitacoraCabina')->find();
		$stats = $query
			->select([
				'Total' => $query->func()->count('*'),
				'FirstOne' => $query->func()->min('fecha', ['date']),
				'LastOne' => $query->func()->max('fecha', ['date']),
			])
			->disableHydration()
			->all();

		return $stats->toArray()[0];
	}

	protected function getProgramasStats(): array
	{
		$query = $this->getTableLocator()->get('Programas')->find();
		$stats = $query
			->select([
				'Total' => $query->func()->count('*'),
			])
			->disableHydration()
			->all();

		return $stats->toArray()[0];
	}

	protected function getDateDiffString(\DateInterval $diff): string
	{
		return $diff->y . ' años, ' . $diff->m . ' meses y ' . $diff->d . ' días';
	}
}

