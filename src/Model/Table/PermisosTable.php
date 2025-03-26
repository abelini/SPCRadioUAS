<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class PermisosTable extends Table {

    public function initialize(array $config): void {
		parent::initialize($config);

		$this->setTable('permisos');
		$this->setDisplayField('name');
		$this->setPrimaryKey('ID');

		$this->belongsToMany('Usuarios', [
			'foreignKey' => 'permisoID',
			'targetForeignKey' => 'usuarioID',
			'joinTable' => 'permisos_usuarios',
		]);
		/*$this->belongsToMany('Locutores', [
			'foreignKey' => 'permiso_id',
			'targetForeignKey' => 'usuario_id',
			'joinTable' => 'permisos_usuarios',
		]);*/
    }


	public function validationDefault(Validator $validator): Validator {
		$validator
			->scalar('name')
			->maxLength('name', 255)
			->notEmptyString('name');

		return $validator;
	}
}
