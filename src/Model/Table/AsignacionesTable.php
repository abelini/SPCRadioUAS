<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\Event\EventInterface;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class AsignacionesTable extends Table {
	
	protected const int NO_LOCUTOR_ID = 999;

	public function initialize(array $config): void {
		parent::initialize($config);

		$this->setTable('asignaciones')
				->setDisplayField('ID')
					->setPrimaryKey('ID')
						->setEntityClass('Asignacion');
		
		$this->belongsTo('Roles', [
			'foreignKey' => 'rolID',
			'propertyName' => 'rol',
		]);
	  
        $this->belongsTo('Locutores', [
			'foreignKey' => 'locutorID',
			'propertyName' => 'locutor',
        ]);
        $this->belongsTo('Dias', [
            'foreignKey' => 'diaID',
        ]);
        $this->belongsTo('Horarios', [
            'foreignKey' => 'horarioID',
        ]);
    }
	
	
	public function afterMarshal(EventInterface $event, EntityInterface $asignacion, \ArrayObject $data, \ArrayObject $options) {
		if (!$asignacion->has('locutorID')) {
			$asignacion->set('locutorID', self::NO_LOCUTOR_ID);
		}
	}

	public function validationDefault(Validator $validator): Validator {
		/*$validator
			->integer('rol_id')
			->requirePresence('rol_id', 'create');
			//->notEmptyString('rol_id');*/

		$validator
			->integer('diaID')
			->notEmptyString('diaID');

		$validator
			->integer('horarioID')
			->notEmptyString('horarioID');

		return $validator;
    }

	public function buildRules(RulesChecker $rules): RulesChecker {
		//$rules->add($rules->existsIn(['locutor_id'], 'Locutores'), ['errorField' => 'locutor_id']);
		$rules->add($rules->existsIn(['diaID'], 'Dias'), ['errorField' => 'diaID']);
		$rules->add($rules->existsIn(['horarioID'], 'Horarios'), ['errorField' => 'horarioID']);

		return $rules;
	}
}
