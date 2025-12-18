<?php
declare(strict_types=1);

namespace SPC\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class PermisosUsuariosTable extends Table
{

	public function initialize(array $config): void
	{
		parent::initialize($config);

		$this->setTable('permisos_usuarios');
		$this->setDisplayField('ID');
		$this->setPrimaryKey('ID');

		$this->belongsTo('Usuarios', [
			'foreignKey' => 'usuarioID',
			'joinType' => 'INNER',
		]);
		$this->belongsTo('Permisos', [
			'foreignKey' => 'permisoID',
			'joinType' => 'INNER',
		]);
	}

	public function validationDefault(Validator $validator): Validator
	{
		$validator
			->integer('usuarioID')
			->notEmptyString('usuarioID');

		$validator
			->integer('permisoID')
			->notEmptyString('permisoID');

		return $validator;
	}

	public function buildRules(RulesChecker $rules): RulesChecker
	{
		$rules->add($rules->existsIn(['usuarioID'], 'Usuarios'), ['errorField' => 'usuarioID']);
		$rules->add($rules->existsIn(['permisoID'], 'Permisos'), ['errorField' => 'permisoID']);

		return $rules;
	}
}

