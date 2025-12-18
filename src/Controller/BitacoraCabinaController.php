<?php
declare(strict_types=1);

namespace SPC\Controller;

use SPC\Model\Entity\Horario;
use SPC\Model\Entity\ReportesPrograma;
use Cake\Collection\Collection;
use Cake\Database\Expression\QueryExpression;
use Cake\Datasource\EntityInterface;
use Cake\Event\EventInterface;
use Cake\Http\Response;
use Cake\I18n\Date;
use Cake\I18n\Time;
use Cake\I18n\DateTime;
use Cake\ORM\Query\SelectQuery;


class BitacoraCabinaController extends AppController
{

	protected const int TOLERANCIA = 1;

	protected int $disabledReport = 0;

	public function initialize(): void
	{
		parent::initialize();
		$this->Authentication->allowUnauthenticated(['display', 'update']);
	}

	public function display(): Response
	{
		$bitacora = $this->BitacoraCabina->findOrCreate(['fecha' => $this->requestedDate()]);
		$bitacora = $this->BitacoraCabina->loadInto($bitacora, ['ReportesCabinas', 'ReportesCabinas.Locutores', 'ReportesCabinas.ReportesProgramas']);
		$bitacora->setNew(false);

		$asignaciones = $this->getAsignacionesForTheDay($bitacora->fecha);

		$programStatuses = ReportesPrograma::STATUS_OPTIONS;

		$disabledSubmit = (new Date())->greaterThan($bitacora->fecha) && !($this->request->getQuery('enable') !== null) && !($this->request->getQuery('update') !== null);

		$checkTimeToDisable = fn($horario, $report) => $this->checkDisabledControls($horario, $report, $disabledSubmit);

		$this->disabledReport = (int) $this->request->getQuery('update') ?? 0;

		$this->set(compact('bitacora', 'asignaciones', 'programStatuses', 'disabledSubmit', 'checkTimeToDisable', ));
		return $this->render();
	}

	protected function checkDisabledControls(Horario $horario, int $singleDisable, bool $disabledSubmit): bool
	{
		if ($this->request->getQuery('enable') !== null) {
			return false;
		}
		if (!$disabledSubmit) {
			return false;
		}
		if ($this->disabledReport == $singleDisable) {
			return false;
		}

		return true;
		//	Since this disables the inputs, the values already set get lost
		//$now = new Time();
		//return $now->greaterThan($horario->hora_fin->setHours($horario->hora_fin->getHours() + self::TOLERANCIA)) || $now->lessThanOrEquals($horario->hora_inicio);
	}

	protected function requestedDate(): Date
	{
		$d = $this->request->getQuery('d') ?? 'now';
		try {
			return new Date($d);
		} catch (\DateMalformedStringException $e) {
			return new Date('now');
		}
	}

	protected function getAsignacionesForTheDay(Date $dia): array
	{
		$rol = $this->getTableLocator()
			->get('Roles')
			->find()
			->where(['fechaInicio' => $dia->startOfWeek()])

			->contain('Asignaciones', function (SelectQuery $query) use ($dia) {
				return $query->where(['diaID' => $dia->dayOfWeek])->orderByAsc('horaInicio');
			})
			->contain('Asignaciones.Locutores', function (SelectQuery $query) {
				return $query->select(['ID', 'name', 'photo']);
			})
			->contain('Asignaciones.Horarios', function (SelectQuery $query) {
				return $query->select(['ID', 'horaInicio', 'horaFin', 'turnoID']);
			})
			->contain('Asignaciones.Dias.Programas', function (SelectQuery $query) {
				return $query->orderByAsc('horaInicio');
			})
			->first();

		// Filtro para que al ultimo locutor le aparezcan los programas más alla de su horario.
		// Ej. Locutor sale a las 8PM, listar programas de las 10PM (Culiacanazos)
		$ids = array_keys($rol->asignaciones);
		$ultimoLocutor = end($ids);

		foreach ($rol->asignaciones as $locutor => $asignacion) {
			$programas = new Collection($asignacion->dia->programas);
			if ($locutor !== $ultimoLocutor) {
				$programas = $programas->filter(function ($programa, $key) use ($asignacion) {
					return ($programa->horaInicio >= $asignacion->horario->horaInicio && $programa->horaInicio < $asignacion->horario->horaFin);
				})->reject(function ($programa) {
					return !$programa->isReportable();
				});
				$rol->asignaciones[$locutor]->dia->programas = $programas->toArray();
			} else {
				// Filtro para que al ultimo locutor le aparezcan los programas más alla de su horario.
				$programas = $programas->filter(function ($programa, $key) use ($asignacion) {
					return ($programa->horaInicio >= $asignacion->horario->horaInicio /*&& $programa->horaInicio < $asignacion->horario->horaFin*/);
				})->reject(function ($programa) {
					return !$programa->isReportable();
				});
				$rol->asignaciones[$locutor]->dia->programas = $programas->toArray();
			}
		}
		return $rol->asignaciones;
	}


	public function update()
	{
		$bitacora = $this->BitacoraCabina->get($this->request->getData('ID'));
		if ($this->request->is('put')) {
			$bitacora = $this->BitacoraCabina->patchEntity($bitacora, $this->request->getData(), ['validate' => false, 'associated' => ['ReportesCabinas' => ['associated' => ['ReportesProgramas']]]]);
			debug($bitacora->fecha);
			if ($this->BitacoraCabina->save($bitacora)) {
				$this->Flash->success('Bitácora actualizada...');
				return $this->redirect($this->referer());
			}

			$this->Flash->error('Error al intentar guardar los cambios. Intenta más tarde.');//debug($bitacora->getErrors());
			return $this->redirect($this->referer());
		}
		$this->set(compact('bitacora'));
	}

	public function beforeRender(EventInterface $event)
	{
		$this->viewBuilder()->setLayout('cabina');
	}
}

