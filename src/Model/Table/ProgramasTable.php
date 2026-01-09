<?php
declare(strict_types=1);

namespace SPC\Model\Table;

use SPC\Model\Entity\Programa;
use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class ProgramasTable extends Table
{

	public function initialize(array $config): void
	{
		parent::initialize($config);

		$this->setTable('programas');
		$this->setDisplayField('name');
		$this->setPrimaryKey('ID');

		$this->hasMany('ReportesProgramas')
			->setForeignKey('programaID')
			->setProperty('reportes')
			->setDependent(true);

		$this->belongsToMany('Dias', [
			'foreignKey' => 'programaID',
			'targetForeignKey' => 'diaID',
			'joinTable' => 'DiasProgramas',
		]);
	}

	#[\Override]
	public function findAll(SelectQuery $query): SelectQuery
	{
		return $query->whereNotInList('Programas.ID', Programa::TEMP_OUT_OF_AIR);
	}

	#[\Override]
	public function findList(SelectQuery $query, \Closure|array|string|null $keyField = null, \Closure|array|string|null $valueField = null, \Closure|array|string|null $g = null, string $s = ';'): SelectQuery
	{
		$query->select(['ID', 'name'])
			->whereNotInList('Programas.ID', Programa::TEMP_OUT_OF_AIR)
			->where(['Programas.reportable' => true]);

		return parent::findList(
			$query,
			keyField: $keyField ?? 'ID',
			valueField: $valueField ?? 'name'
		);
	}

	public function validationDefault(Validator $validator): Validator
	{
		$validator
			->allowEmptyString('ID', 'update')
			->add('ID', 'valid', ['rule' => 'numeric']);

		$validator
			->scalar('name')
			->maxLength('name', 255)
			->requirePresence('name', 'create')
			->notEmptyString('name');

		$validator
			->time('horaInicio')
			->requirePresence('horaInicio', 'create')
			->notEmptyTime('horaInicio');

		$validator
			->time('horaFin')
			->requirePresence('horaFin', 'create')
			->notEmptyTime('horaFin');

		$validator
			->scalar('produccion')
			->maxLength('produccion', 255)
			->requirePresence('produccion', 'create')
			->notEmptyString('produccion');

		$validator
			->boolean('uo')
			->requirePresence('uo', 'create')
			->notEmptyString('uo');

		$validator
			->boolean('musical')
			->requirePresence('musical', 'create')
			->notEmptyString('musical');

		$validator
			->add('horaFin', 'afterStart', [
				'rule' => function ($value, $context) {
					if (isset($context['data']['horaInicio'])) {
						return $value > $context['data']['horaInicio'];
					}
					return true;
				},
				'message' => 'La hora de fin no puede ser menor o igual a la hora de inicio.'
			]);

		$validator
			->add('dias', 'atLeastOne', [
				'rule' => function ($value, $context) {
					// Verificamos si vienen datos en el array de 'dias'
					return !empty($value) && isset($value['_ids']) && !empty($value['_ids']);
				},
				'message' => 'Debes seleccionar al menos un día de transmisión para el programa.'
			]);

		return $validator;
	}
}

