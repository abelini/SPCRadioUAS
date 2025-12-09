<?php
declare(strict_types=1);

namespace SPC\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class DiasProgramasTable extends Table
{

    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('dias_programas');
        $this->setDisplayField('ID');
        $this->setPrimaryKey('ID');

        $this->belongsTo('Dias', [
            'foreignKey' => 'diaID',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Programas', [
            'foreignKey' => 'programaID',
            'joinType' => 'INNER',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('diaID')
            ->notEmptyString('diaID');

        $validator
            ->integer('programaID')
            ->notEmptyString('programaID');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['diaID'], 'Dias'), ['errorField' => 'diaID']);
        $rules->add($rules->existsIn(['programaID'], 'Programas'), ['errorField' => 'programaID']);

        return $rules;
    }
}

