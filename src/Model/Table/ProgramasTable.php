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

	/**
	 * Aplica el filtro outOfAir por defecto en todas las queries públicas.
	 * Se omite cuando la query trae la opción 'admin' => true,
	 * o cuando ya trae explícitamente un filtro sobre outOfAir via opción 'filterOutOfAir' => false.
	 */
	public function beforeFind(EventInterface $event, SelectQuery $query, ArrayObject $options): void
	{
		$options = $query->getOptions();

		if (!empty($options['admin'])) {
			return;
		}

		if (!empty($options['filterOutOfAir']) && $options['filterOutOfAir'] === false) {
			return;
		}

		$query->where(['Programas.outOfAir' => false]);
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

		$validator
			->boolean('musical')
			->requirePresence('musical', 'create')
			->notEmptyString('musical');

		$validator->add('horaFin', 'afterStart', [
			'rule' => $this->validateEndTimeAfterStart(...),
			'message' => 'La hora de fin no puede ser menor o igual a la hora de inicio.',
		]);

		$validator->add('dias', 'atLeastOne', [
			'rule' => $this->validateAtLeastOneDay(...),
			'message' => 'Debes seleccionar al menos un día de transmisión para el programa.',
		]);

		return $validator;
	}

	/**
	 * Valida que horaFin sea posterior a horaInicio, excepto cuando es medianoche (00:00:00).
	 */
	private function validateEndTimeAfterStart(mixed $value, array $context): bool
	{
		if ($value === '00:00:00') {
			return true;
		}
		return !isset($context['data']['horaInicio']) || $value > $context['data']['horaInicio'];
	}

	/**
	 * Valida que se haya seleccionado al menos un día de transmisión.
	 */
	private function validateAtLeastOneDay(mixed $value, array $context): bool
	{
		return !empty($value) && isset($value['_ids']) && !empty($value['_ids']);
	}
}