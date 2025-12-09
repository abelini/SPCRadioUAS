<?php
declare(strict_types=1);

namespace SPC\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class TipoSolicitudTable extends Table
{

    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('tipo_solicitud');
        $this->setDisplayField('name');
        $this->setPrimaryKey('ID');

        $this->hasMany('Solicitudes', [
            'foreignKey' => 'tipoSolicitudID',
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('imagen')
            ->maxLength('imagen', 255)
            ->requirePresence('imagen', 'create')
            ->notEmptyString('imagen');

        $validator
            ->scalar('icon')
            ->maxLength('icon', 64)
            ->requirePresence('icon', 'create')
            ->notEmptyString('icon');

        return $validator;
    }
}

