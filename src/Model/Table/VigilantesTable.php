<?php
declare(strict_types=1);

namespace SPC\Model\Table;

use SPC\Model\Entity\Permiso;
use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class VigilantesTable extends Table
{

	public function initialize(array $config): void
	{
		parent::initialize($config);

		$this->setTable('usuarios');
		$this->setDisplayField('name');
		$this->setPrimaryKey('ID');

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
			->orderAsc('fullname')
			->matching('Permisos', function (SelectQuery $query) {
				return $query->where(['Permisos.ID' => Permiso::VIGILANTE]);
			});
	}

	#[\Override]
	public function findList(SelectQuery $query, \Closure|array|string|null $keyField = null, \Closure|array|string|null $valueField = null, \Closure|array|string|null $g = null, string $s = ';'): SelectQuery
	{
		$finder = $query->select(['ID', 'name'])
			->matching('Permisos', function (SelectQuery $query) {
				return $query->where(['Permisos.ID' => Permiso::VIGILANTE]);
			});
		return parent::findList($finder, keyField: $keyField, valueField: $valueField);
	}
}

