<?php
declare(strict_types=1);

namespace SPC\Model\Table;

use ArrayObject;
use Cake\Event\EventInterface;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class TemasProgramasTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('temas_programas');
        $this->setDisplayField('tema');
        $this->setPrimaryKey('ID');

        $this->belongsTo('Programas', [
            'foreignKey' => 'ProgramaID',
            'joinType' => 'INNER',
        ]);
    }

    public function beforeSave(EventInterface $event, EntityInterface $entity, ArrayObject $options)
    {
        // Solo nos importa si estamos asignando un programa
        if ($entity->has('ProgramaID') && !empty($entity->ProgramaID)) {

            // Buscamos si ya existe UN conductor para este programa
            $conductorExistente = $this->find()
                ->select(['ID'])
                ->where(['ProgramaID' => $entity->ProgramaID])
                ->first();

            if ($conductorExistente) {
                // OPCIÓN A: "Modificar el registro existente" (Recomendada)
                $entity->ID = $conductorExistente->ID;
                $entity->setNew(false); // Le decimos a Cake: "No es nuevo, actualiza"

                // OPCIÓN B: "Eliminar antes de guardar"
                // $this->delete($conductorExistente);
            }
        }
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('ProgramaID')
            ->requirePresence('ProgramaID', 'create')
            ->notEmptyString('ProgramaID');

        $validator
            ->scalar('tema')
            ->maxLength('tema', 255)
            ->requirePresence('tema', 'create')
            ->notEmptyString('tema');

        return $validator;
    }
}
