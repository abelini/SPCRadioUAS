<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class UsuariosTable extends Table {

	public function initialize(array $config): void {
		parent::initialize($config);

		$this->setTable('usuarios');
		$this->setDisplayField('name');
		$this->setPrimaryKey('ID');

		$this->belongsToMany('Permisos', [
			'foreignKey' => 'usuarioID',
			'targetForeignKey' => 'permisoID',
			'joinTable' => 'permisos_usuarios',
			'saveStrategy' => 'replace',
		]);
	}

	
	public function validationDefault(Validator $validator): Validator {
        $validator
            ->integer('empleado')
            ->requirePresence('empleado', 'create')
            ->notEmptyString('empleado');

        $validator
            ->scalar('username')
            ->maxLength('username', 30)
            ->notEmptyString('username');

        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->notEmptyString('password');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->notEmptyString('name');

        $validator
            ->scalar('fullname')
            ->maxLength('fullname', 255)
            ->requirePresence('fullname', 'create')
            ->notEmptyString('fullname');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email');

        $validator
            ->boolean('base')
            ->notEmptyString('base');

        return $validator;
    }

	public function buildRules(RulesChecker $rules): RulesChecker {
		$rules->add($rules->isUnique(['username']), ['errorField' => 'username']);

		return $rules;
	}
}
