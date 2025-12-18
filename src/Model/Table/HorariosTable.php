<?php
declare(strict_types=1);

namespace SPC\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class HorariosTable extends Table
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

        $this->setTable('horarios');
        $this->setDisplayField('ID');
        $this->setPrimaryKey('ID');

        $this->belongsTo('Turnos', [
            'foreignKey' => 'turnoID',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('Asignaciones', [
            'foreignKey' => 'horarioID',
        ]);
        $this->belongsToMany('Dias', [
            'foreignKey' => 'horarioID',
            'targetForeignKey' => 'diaID',
            'joinTable' => 'DiasHorarios',
        ]);
    }

    #[\Override]
    public function findList(SelectQuery $query, \Closure|array|string|null $keyField = null, \Closure|array|string|null $valueField = null, \Closure|array|string|null $g = null, string $s = ';'): SelectQuery
    {
        $finder = $query->select(['ID', 'horaInicio', 'horaFin', 'turnoID']);
        //->matching();
        return parent::findList(
            $finder,
            keyField: $this->getPrimaryKey(),
            valueField: function ($horario) {
                return $horario->horaInicio . ' → ' . $horario->horaFin;
            }
        );
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
            ->time('horaInicio')
            ->notEmptyTime('horaInicio');

        $validator
            ->time('horaFin')
            ->notEmptyTime('horaFin');

        $validator
            ->integer('turnoID')
            ->notEmptyString('turnoID');

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
        $rules->add($rules->existsIn(['turnoID'], 'Turnos'), ['errorField' => 'turnoID']);

        return $rules;
    }
}

