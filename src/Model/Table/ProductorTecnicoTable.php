<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\Permiso;
use Cake\Database\Expression\QueryExpression;
use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class ProductorTecnicoTable extends Table {

    public function initialize(array $config): void {
		parent::initialize($config);

		$this->setTable('usuarios');
		$this->setDisplayField('name');
		$this->setPrimaryKey('ID');
		
		$this->hasMany('Solicitudes', [
			'foreignKey' => 'productorID',
        ]);
	  
		$this->belongsToMany('Permisos', [
			'foreignKey' => 'usuarioID',
			'targetForeignKey' => 'permisoID',
			'joinTable' => 'permisos_usuarios',
		]);
	}

	#[\Override]
	public function findList(SelectQuery $query, \Closure|array|string|null $keyField = null, \Closure|array|string|null $valueField = null, \Closure|array|string|null $g = null, string $s = ';') : SelectQuery {
		$finder = $query->select(['ID', 'name'])
					->matching('Permisos', function(SelectQuery $query) {
						return $query->where(['Permisos.ID' => Permiso::PRODUCTORES_TECNICOS]);
					});
		return parent::findList($finder, keyField:$keyField, valueField:$valueField);
	}
}
