<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class UpdatesTable extends Table {

	public function initialize(array $config): void {
		parent::initialize($config);

		$this->setTable('updates_reportes_vigilancia');
		$this->setEntityClass('Update');
		$this->setDisplayField('observacion');
		$this->setPrimaryKey('ID');
		
		$this->belongsTo('Incidencias')
			->setForeignKey('incidenciaID');
		
		$this->belongsTo('Usuarios')
			->setForeignKey('userID');
	}

	public function validationDefault(Validator $validator): Validator {
        $validator
            ->integer('incidenciaID')
            ->requirePresence('incidenciaID', 'create')
            ->notEmptyString('incidenciaID');

        $validator
            ->integer('userID')
            ->requirePresence('userID', 'create')
            ->notEmptyString('userID');

        $validator
            ->scalar('observacion')
            ->requirePresence('observacion', 'create')
            ->notEmptyString('observacion');

        $validator
            ->dateTime('date')
            ->requirePresence('date', 'create')
            ->notEmptyDateTime('date');

        return $validator;
	}
}
