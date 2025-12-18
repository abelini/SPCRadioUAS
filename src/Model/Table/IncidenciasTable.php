<?php
declare(strict_types=1);

namespace SPC\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class IncidenciasTable extends Table
{

	public function initialize(array $config): void
	{
		parent::initialize($config);

		$this->setTable('incidencias');
		$this->setDisplayField('ID');
		$this->setPrimaryKey('ID');

		$this->addBehavior('Timestamp');

		$this->belongsTo('Areas')
			->setForeignKey('areaID')
			->setProperty('area');

		$this->hasOne('DetallesIncidencias')
			->setForeignKey('incidenciaID')
			->setDependent(true)
			->setProperty('detalles');

		$this->hasMany('Updates')
			->setForeignKey('incidenciaID')
			->setDependent(true)
			->setProperty('updates');
	}

	public function validationDefault(Validator $validator): Validator
	{
		$validator
			->integer('areaID')
			->requirePresence('areaID', 'create')
			->notEmptyString('areaID');

		$validator
			->date('fecha')
			->requirePresence('fecha', 'create')
			->notEmptyDate('fecha');

		$validator
			->scalar('observaciones')
			->requirePresence('observaciones', 'create')
			->notEmptyString('observaciones');

		return $validator;
	}
}

