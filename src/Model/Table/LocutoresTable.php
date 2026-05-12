<?php
declare(strict_types=1);

namespace SPC\Model\Table;

use SPC\Model\Entity\Permiso;
use Cake\I18n\DateTime;
use Cake\Database\Expression\QueryExpression;
use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class LocutoresTable extends Table
{

	public function initialize(array $config): void
	{
		parent::initialize($config);

		$this->setTable('usuarios');

		$this->setDisplayField('name')
			->setPrimaryKey('ID')
			->setEntityClass('Locutor');

		$this->hasMany('Asignaciones', [
			'foreignKey' => 'locutorID',
		]);

		$this->hasMany('Solicitudes', [
			'foreignKey' => 'primerAsignadoID',
			'bindingKey' => 'ID',
		]);

		$this->belongsToMany('Permisos', [
			'foreignKey' => 'usuarioID',
			'targetForeignKey' => 'permisoID',
			'joinTable' => 'permisos_usuarios',
		]);
	}

	#[\Override]
	public function findAll(SelectQuery $query): SelectQuery
	{
		return $query
			->selectAllExcept($this, ['password'])
			->orderByAsc('fullname')
			->matching('Permisos', function (SelectQuery $query) {
				return $query->where(['Permisos.ID' => Permiso::LOCUTOR]);
			});
	}

	#[\Override]
	public function findList(SelectQuery $query, \Closure|array|string|null $keyField = null, \Closure|array|string|null $valueField = null, \Closure|array|string|null $g = null, string $s = ';'): SelectQuery
	{
		$finder = $query->select(['ID', 'name', 'email'])
			->matching('Permisos', function (SelectQuery $query) {
				return $query->where(['Permisos.ID' => Permiso::LOCUTOR]);
			});
		return parent::findList($finder, keyField: $keyField, valueField: $valueField);
	}

	public function findDiasFeriadosAsignados(SelectQuery $query, array $diasFeriados, DateTime $today): SelectQuery
	{
		$query
			->enableAutoFields(false)
			->where(['base' => true]);

		if (count($diasFeriados) > 0) {
			$ors = [];
			foreach ($diasFeriados as $feriado) {
				$ors[] = [
					'Asignaciones.diaID' => $feriado->dayOfWeek,
					'Roles.fechaInicio' => $feriado->startOfWeek(),
				];
			}

			$query
				->matching('Asignaciones')
				->innerJoinWith('Asignaciones.Roles')
				->where(fn(QueryExpression $exp) => $exp->or($ors));
		} else {
			$query->matching('Asignaciones')->where(['Asignaciones.diaID' => 0]);
		}

		return $query;
	}

	public function findMaestrosAsignados(SelectQuery $query, DateTime $empieza, DateTime $termina): SelectQuery
	{
		return $query
			->enableAutoFields(false)
			->where(['base' => true])
			->matching('Solicitudes', fn(SelectQuery $query) => $query
				->select(['ID', 'evento', 'fecha'])
				->where(fn(QueryExpression $exp) => $exp->between('fecha', $empieza, $termina)));
	}
}

