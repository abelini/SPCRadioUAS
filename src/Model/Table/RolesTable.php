<?php
declare(strict_types=1);

namespace SPC\Model\Table;

use SPC\Model\Entity\Rol;
use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class RolesTable extends Table
{

	public function initialize(array $config): void
	{
		parent::initialize($config);

		$this->setTable('roles');

		$this->setDisplayField('fechaInicio')
			->setPrimaryKey('ID')
			->setEntityClass('Rol');

		$this->belongsTo('Turnos', [
			'foreignKey' => 'turnoID',
			'joinType' => 'INNER',
		]);

		$this->hasMany('Asignaciones', [
			'sort' => [
				'diaID' => 'ASC',
				'horarioID' => 'ASC'
			]
		])
			->setForeignKey('rolID')
			->setDependent(true);
	}

	public function findPrevious(SelectQuery $query, Rol $rol)
	{
		return $query->where(['fechaFin' => $rol->fechaInicio->addDays(-1)]);
	}

	public function findNext(SelectQuery $query, Rol $rol)
	{
		return $query->where(['fechaInicio' => $rol->fechaFin->addDays(1)]);
	}

	public function validationDefault(Validator $validator): Validator
	{
		$validator
			->date('fechaInicio')
			->requirePresence('fechaInicio', 'create')
			->notEmptyDate('fechaInicio');

		$validator
			->date('fechaFin')
			->requirePresence('fechaFin', 'create')
			->notEmptyDate('fechaFin');

		$validator
			->integer('turnoID')
			->notEmptyString('turnoID');

		return $validator;
	}

	public function buildRules(RulesChecker $rules): RulesChecker
	{
		$rules->add($rules->existsIn(['turnoID'], 'Turnos'), ['errorField' => 'turnoID']);
		return $rules;
	}
}

