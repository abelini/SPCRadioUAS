<?php
declare(strict_types=1);

namespace SPC\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\EventInterface;
use ArrayObject;

class ProgramasTable extends Table
{

	public function initialize(array $config): void
	{
		parent::initialize($config);

		$this->setTable('programas');
		$this->setDisplayField('name');
		$this->setPrimaryKey('ID');

		$this->hasOne('TemasProgramas')
			->setForeignKey('ProgramaID')
			->setProperty('tema')
			->setDependent(true);

		$this->belongsTo('CategoriasProgramas')
			->setForeignKey('categoryID')
			->setProperty('categoria');

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

	public function beforeFind(EventInterface $event, SelectQuery $query, ArrayObject $options): void
	{
		$options = $query->getOptions();

		if (isset($options['admin']) && $options['admin'] === true) {
			return;
		}

		if (!str_contains(serialize($query->clause('where')), 'outOfAir')) {
			$query->where(['Programas.outOfAir' => false]);
		}
	}

	#[\Override]
	public function findList(SelectQuery $query, \Closure|array|string|null $keyField = null, \Closure|array|string|null $valueField = null, \Closure|array|string|null $g = null, string $s = ';'): SelectQuery
	{
		$query->select(['ID', 'name'])
			->where([
				'Programas.outOfAir' => false,
				'Programas.reportable' => true
			])
			->orderByAsc('name');

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
			->scalar('conduccion')
			->maxLength('conduccion', 255);
		//->requirePresence('conduccion', 'create')
		//->notEmptyString('conduccion');

		$validator
			->boolean('musical')
			->requirePresence('musical', 'create')
			->notEmptyString('musical');

		$validator
			->add('horaFin', 'afterStart', [
				'rule' => function ($value, $context) {
					if ($value == '00:00:00')
						return true;
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
					return !empty($value) && isset($value['_ids']) && !empty($value['_ids']);
				},
				'message' => 'Debes seleccionar al menos un día de transmisión para el programa.'
			]);

		return $validator;
	}
}

