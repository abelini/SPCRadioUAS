<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\Permiso;
use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class LocutoresTable extends Table {

	public function initialize(array $config): void {
		parent::initialize($config);

		$this->setTable('usuarios');
		
		$this->setDisplayField('name')
				->setPrimaryKey('ID')
				->setEntityClass('Locutor');

		$this->hasMany('Asignaciones', [
			'foreignKey' => 'locutorID',
		]);
		/*$this->hasMany('ReportesCabinas', [
			'foreignKey' => 'usuario_id',
		]);
		$this->hasMany('Solicitudes', [
			'foreignKey' => 'usuario_id',
		]);*/
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
	public function findAll(SelectQuery $query) : SelectQuery {
		return $query
				->selectAllExcept($this, ['password'])
				->orderByAsc('fullname')
				->matching('Permisos', function(SelectQuery $query) {
					return $query->where(['Permisos.ID' => Permiso::LOCUTOR]);
				});
	}
	
	#[\Override]
	public function findList(SelectQuery $query, \Closure|array|string|null $keyField = null, \Closure|array|string|null $valueField = null, \Closure|array|string|null $g = null, string $s = ';') : SelectQuery {
		$finder = $query->select(['ID', 'name', 'email'])
					->matching('Permisos', function(SelectQuery $query) {
						return $query->where(['Permisos.ID' => Permiso::LOCUTOR]);
					});
		return parent::findList($finder, keyField:$keyField, valueField:$valueField);
	}
}
