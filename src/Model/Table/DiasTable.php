<?php
declare(strict_types=1);

namespace SPC\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class DiasTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('dias');
        $this->setDisplayField('name');
        $this->setPrimaryKey('ID');

        $this->hasMany('Asignaciones', [
            'foreignKey' => 'diaID',
        ]);
        $this->belongsToMany('Horarios', [
            'foreignKey' => 'diaID',
            'targetForeignKey' => 'horarioID',
            'joinTable' => 'DiasHorarios',
        ]);
        $this->belongsToMany('Programas', [
            'foreignKey' => 'diaID',
            'targetForeignKey' => 'programaID',
            'joinTable' => 'DiasProgramas',
        ]);
    }
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('name')
            ->maxLength('name', 15)
            ->notEmptyString('name');

        return $validator;
    }
}

