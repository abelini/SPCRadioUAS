<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\Horario;
use App\Model\Entity\ReportesPrograma;
use Cake\Collection\Collection;
use Cake\Database\Expression\QueryExpression;
use Cake\Datasource\EntityInterface;
use Cake\Event\EventInterface;
use Cake\Http\Response;
use Cake\I18n\Date;
use Cake\I18n\Time;
use Cake\I18n\DateTime;
use Cake\ORM\Query\SelectQuery;


class BitacoraCabinaController extends AppController {
	
	protected const int TOLERANCIA = 1;
	
	public function initialize() : void {
		parent::initialize();
		$this->Authentication->allowUnauthenticated(['display', 'update']);
	}
	
	public function display() : Response {
		$bitacora = $this->BitacoraCabina->findOrCreate(['fecha' => $this->requestedDate()]);
		$bitacora = $this->BitacoraCabina->loadInto($bitacora, ['ReportesCabinas', 'ReportesCabinas.Locutores', 'ReportesCabinas.ReportesProgramas']);
		$bitacora->setNew(false);
		
		$asignaciones = $this->getAsignacionesForTheDay($bitacora->fecha);

		$programStatuses = ReportesPrograma::STATUS_OPTIONS;

		$disabledSubmit = (new Date())->greaterThan($bitacora->fecha) && !($this->request->getQuery('enable') !== null);

		$checkTimeToDisable = fn($horario) => $this->checkDisabledControls($horario, $disabledSubmit);

		$this->set(compact('bitacora', 'asignaciones', 'programStatuses', 'disabledSubmit', 'checkTimeToDisable'));
		return $this->render();
	}
	
	protected function checkDisabledControls(Horario $horario, bool $disabledSubmit) : bool {
		if($this->request->getQuery('enable') !== null) {
			return false;
		}
		if($disabledSubmit) {
			return true;
		} 
		return false;
		//	Since this disables the inputs, the values already set get lost
		//$now = new Time();
		//return $now->greaterThan($horario->hora_fin->setHours($horario->hora_fin->getHours() + self::TOLERANCIA)) || $now->lessThanOrEquals($horario->hora_inicio);
	}
	
	protected function requestedDate() : Date {
		$d = $this->request->getQuery('d') ?? 'now';
		try {
			return new Date($d);
		} catch(\DateMalformedStringException $e) {
			return new Date('now');
		}
	}
	
	protected function getAsignacionesForTheDay(Date $dia) : array {
		$rol = $this->getTableLocator()
					->get('Roles')
						->find()
							->where(['fechaInicio' => $dia->startOfWeek()])
							
							->contain('Asignaciones', function(SelectQuery $query) use($dia) {
								return $query->where(['diaID' => $dia->dayOfWeek])->orderAsc('horaInicio');
							})
							->contain('Asignaciones.Locutores', function(SelectQuery $query) {
								return $query->select(['ID', 'name', 'photo']);
							})
							->contain('Asignaciones.Horarios', function(SelectQuery $query) {
								return $query->select(['ID', 'horaInicio', 'horaFin', 'turnoID']);
							})
							->contain('Asignaciones.Dias.Programas', function(SelectQuery $query) {
								return $query->orderAsc('horaInicio');
							})
							->first();
		foreach($rol->asignaciones as $id => $asignacion) {
			$programas = new Collection($asignacion->dia->programas); 
			$programas = $programas->filter(function($programa, $key) use($asignacion) {
					return ($programa->horaInicio >= $asignacion->horario->horaInicio && $programa->horaInicio < $asignacion->horario->horaFin);
				})->reject(function($programa) {
					return !$programa->isReportable();
			});
			$rol->asignaciones[$id]->dia->programas = $programas->toArray();
		}
		return $rol->asignaciones;
	}
	

	public function update() {
		$bitacora = $this->BitacoraCabina->newEmptyEntity();
		//debug($bitacora);
		if($this->request->is('put')) {
			$bitacora = $this->BitacoraCabina->patchEntity($bitacora, $this->request->getData(), ['associated' => ['ReportesCabinas' => ['associated' => ['ReportesProgramas']]]]);
			//debug($bitacora);
			if($this->BitacoraCabina->save($bitacora)) {
				$this->Flash->success('Bitácora actualizada...');
				return $this->redirect($this->referer());
			}

			$this->Flash->error('Error al intentar guardar los cambios. Intenta más tarde.');//debug($bitacora->getErrors());
			return $this->redirect($this->referer());
		}
		$this->set(compact('bitacora'));
	}

	public function beforeRender(EventInterface $event) {
		$this->viewBuilder()->setLayout('cabina');
	}
}
