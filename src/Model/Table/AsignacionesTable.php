<?php
declare(strict_types=1);

namespace SPC\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Database\QueryInterface;
use SPC\Model\Entity\Permiso;

class AsignacionesTable extends Table
{

	public function initialize(array $config): void
	{
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

	public function validationDefault(Validator $validator): Validator
	{
		$validator
			->integer('locutorID')
			->notEmptyString('locutorID');

		$validator
			->integer('diaID')
			->notEmptyString('diaID');

		$validator
			->integer('horarioID')
			->notEmptyString('horarioID');

		return $validator;
	}

	public function buildRules(RulesChecker $rules): RulesChecker
	{
		$rules->add($rules->existsIn(['diaID'], 'Dias'), ['errorField' => 'diaID']);
		$rules->add($rules->existsIn(['horarioID'], 'Horarios'), ['errorField' => 'horarioID']);

		return $rules;
	}
}

