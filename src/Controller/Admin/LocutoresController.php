<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Collection\Collection;
use Cake\Database\Expression\QueryExpression;
use Cake\I18n\DateTime;
use Cake\ORM\Query\SelectQuery;


class LocutoresController extends AppController {
    
    protected const int HORAS_EXTRAS_POR_TURNO = 6;
    
    protected const int HORAS_EXTRAS_POR_EVENTO = 4;
    
	protected const array DIAS_INHABILES = [
		'Feb 5th',
		'Mar 21st',
		//'Apr 18th', // <--- prueba
		//'Apr 21st', // <--   "
		'May 1st',
		'May 5th',
		'May 10th',
		'Sep 16th',
		'Nov 1st',
		'Nov 2nd',
		'Nov 20th',
	];
    
    public function horasExtras() {
	    $today = DateTime::now();
	    $quincenaDelMes = ($today->day >= 1 && $today->day <= 15)? 2 : 1;
	    
	    $today = ($quincenaDelMes == 2)? $today->modify('-1 month') : $today;
		
	    $empieza = match($quincenaDelMes) {
		    1 => $today->startOfMonth(),
		    2 => $today->day(16),
	    };
	    $termina = match($quincenaDelMes) {
		    1 => $today->day(15),
		    2 => $today->endOfMonth(),
	    };
	    
		$feriadosDeLaQuincena = array();
		
		foreach(self::DIAS_INHABILES as $feriado) {
			$feriado = new DateTime($feriado);
			if($feriado->isWeekday()) {
				if($feriado->between($empieza, $termina)) {
					array_push($feriadosDeLaQuincena, $feriado);
				}
			}
		}
		/*	--------------------------------------------------------------------------------------------------------------------
		//	--------------------------------------------------------------------------------------------------------------------
		//	Esta consulta funciona para cuando solo hay dias feriados EN UNA SOLA SEMANA/ROL
		//	--------------------------------------------------------------------------------------------------------------------
		//	--------------------------------------------------------------------------------------------------------------------
		*/
		$locutoresAsignados = $this->Locutores->find()
										->enableAutoFields(false)
											->where(['base' => true])
											->matching('Asignaciones', function(SelectQuery $query) use($feriadosDeLaQuincena) {
												$cond = [];
												if(count($feriadosDeLaQuincena) > 0) {
													foreach($feriadosDeLaQuincena as $f) {
														$cond[] = ['diaID' => $f->dayOfWeek];
													}
												} else {
													$cond = ['diaID' => 0];
												}
												return $query->where(
													conditions:function(QueryExpression $exp, SelectQuery $query) use($cond) {
														return $exp->or($cond);
													},
													overwrite:true
												);
											})
											->matching('Asignaciones.Roles', function(SelectQuery $query) use($feriadosDeLaQuincena, $today) {
												$cond = [];
												if(count($feriadosDeLaQuincena) > 0) {
													foreach($feriadosDeLaQuincena as $f) {
														$cond[] = ['fechaInicio' => $f->startOfWeek()];
													}
												} else {
													$cond = ['fechaInicio' => $today->startOfWeek()];
												}
												return $query->where(function(QueryExpression $exp, SelectQuery $query) use($cond) {
														return $exp->or($cond);
												});
											})
											->all();

		
		$locutores = new Collection($this->Locutores->find()->where(['base' => true])->all());
		$horasXCabina = array();
		$horasXEvento = array();
	
		foreach($locutores as $id => $locutor) {
			$locs = (new Collection($locutoresAsignados))->match(['ID' => $locutor->ID]);
			if($locs->count() == 0) continue;
			
			$horasXCabina[$id]['horas'] = 0;
			foreach($locs as $loc) {
				$horasXCabina[$id]['horas'] += self::HORAS_EXTRAS_POR_TURNO;
			}
			$horasXCabina[$id]['locutor'] = $locutor;
		}
		
		$maestrosAsignados = $this->Locutores->find()
							->enableAutoFields()
							->distinct()
							->where(['base' => true])
							->matching('Solicitudes', function(SelectQuery $query) use($empieza, $termina) {
								return $query
											->select(['ID', 'evento', 'fecha'])
											->where(function(QueryExpression $exp, SelectQuery $query) use($empieza, $termina) {
												return $exp->between('fecha', $empieza, $termina);
											});
							})
							->all();
							
		foreach($locutores as $id => $locutor) {
			$locs = (new Collection($maestrosAsignados))->match(['ID' => $locutor->ID]);
			if($locs->count() == 0) continue;

			$horasXEvento[$id]['horas'] = 0;
			foreach($locs as $loc) {
				$horasXEvento[$id]['horas'] += self::HORAS_EXTRAS_POR_EVENTO;
				$horasXEvento[$id]['eventos'][] = $loc->_matchingData['Solicitudes'];
			}
			$horasXEvento[$id]['locutor'] = $locutor;
			
		}
		
		$this->set(compact('empieza', 'termina'));
		$this->set(compact('feriadosDeLaQuincena', 'horasXCabina', 'horasXEvento'));
		

    }
    
	public function index(){
		$query = $this->Locutores->find();
		$locutores = $this->paginate($query);
		$this->set(compact('locutores'));
	}

	public function view($id = null) {
		$locutore = $this->Locutores->get($id, contain: ['Permisos', 'Asignaciones']);
		$this->set(compact('locutore'));
	}

}
