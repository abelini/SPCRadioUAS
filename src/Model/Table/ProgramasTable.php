<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\Programa;
use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class ProgramasTable extends Table {

	public function initialize(array $config): void {
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
	public function findAll(SelectQuery $query) : SelectQuery {
		return $query->whereNotInList('Programas.id', Programa::TEMP_OUT_OF_AIR);
	}
	
	#[\Override]
	public function findList(SelectQuery $query, \Closure|array|string|null $keyField = null, \Closure|array|string|null $valueField = null, \Closure|array|string|null $g = null, string $s = ';') : SelectQuery {
		return parent::findList(
			$query->select(['ID', 'name'])->whereNotInList('Programas.id', Programa::TEMP_OUT_OF_AIR)->where(['Programas.reportable' => true]),
			keyField: $keyField,
			valueField: $valueField
		);
	}
	
    public function validationDefault(Validator $validator): Validator {
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
		return $validator;
	}
}
