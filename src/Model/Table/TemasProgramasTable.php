<?php
declare(strict_types=1);

namespace SPC\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\EventInterface;
use Cake\Datasource\EntityInterface;
use ArrayObject;

class TemasProgramasTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('temas_programas');
        $this->setDisplayField('tema');
        $this->setPrimaryKey('ID');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Programas', [
            'foreignKey' => 'ProgramaID',
            'joinType' => 'INNER',
        ]);
    }

    public function beforeSave(EventInterface $event, EntityInterface $entity, ArrayObject $options)
    {
        if ($entity->has('ProgramaID') && !empty($entity->get('ProgramaID'))) {
            $conductorExistente = $this->find()
                ->select(['ID'])
                ->where(['ProgramaID' => $entity->get('ProgramaID')])
                ->first();

            if ($conductorExistente) {
                $entity->set('ID', $conductorExistente->get('ID'));
                $entity->setNew(false);
            }
        }
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('ProgramaID')
            ->requirePresence('ProgramaID', 'create')
            ->notEmptyString('ProgramaID')
            ->add('ProgramaID', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('tema')
            ->maxLength('tema', 255)
            //->requirePresence('tema', 'create')
            ->allowEmptyString('tema');

        $validator
            ->scalar('invitados')
            ->maxLength('invitados', 255)
            //->requirePresence('invitados', 'create')
            ->allowEmptyString('invitados');


        return $validator;
    }


    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['ProgramaID']), ['errorField' => 'ProgramaID']);

        return $rules;
    }
}
