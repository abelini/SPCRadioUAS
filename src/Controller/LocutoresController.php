<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Database\Expression\QueryExpression;
use Cake\I18n\DateTime;
use Cake\I18n\Time;
use Cake\ORM\Query\SelectQuery;


class LocutoresController extends AppController {
    
	public function initialize() : void {
		parent::initialize();
		$this->Authentication->allowUnauthenticated(['get']);
	}
	
	public function get() {
		$today = DateTime::now();
		$lastMonday = $today->isMonday()? $today : $today->startOfWeek();
		
		$rol = $this->getTableLocator()
					->get('Roles')
					->find()
						->where(['fechaInicio' => $lastMonday])
						->contain('Asignaciones', function(SelectQuery $query) use($today) {
							return $query
										->where(['DiaID' => $today->dayOfWeek])
										->matching('Horarios', function (SelectQuery $query) {
											$now = new Time();
											return $query
														->where(['Horarios.horaInicio <=' => $now])
														->andWhere(['Horarios.horaFin >' => $now]);
										})
										->contain([
											'Locutores' => function(SelectQuery $query) {
												return $query->select(['ID', 'name']);
											},
											'Horarios',
										]);
						})
						->first();
		if(!empty($rol->asignaciones)){
			$response = [
				'name' => $rol->asignaciones[0]->locutor->name,
				'starts' => $rol->asignaciones[0]->horario->horaInicio->i18nFormat("ha", 'en_US'),
				'ends' => $rol->asignaciones[0]->horario->horaFin->i18nFormat("ha", 'en_US'),
			];
		} else {
			$response = [
				'name' => '',
				'starts' => '',
				'ends' => '',
			];
		}
		$this->viewBuilder()->setLayout(null);
		
		return $this->render()
					->withType('application/json')
						->withStringBody(json_encode($response));
    }

}
