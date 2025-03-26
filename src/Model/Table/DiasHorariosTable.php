<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DiasHorarios Model
 *
 * @property \App\Model\Table\DiasTable&\Cake\ORM\Association\BelongsTo $Dias
 * @property \App\Model\Table\HorariosTable&\Cake\ORM\Association\BelongsTo $Horarios
 *
 * @method \App\Model\Entity\DiasHorario newEmptyEntity()
 * @method \App\Model\Entity\DiasHorario newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\DiasHorario> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DiasHorario get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\DiasHorario findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\DiasHorario patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\DiasHorario> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\DiasHorario|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\DiasHorario saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\DiasHorario>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\DiasHorario>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\DiasHorario>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\DiasHorario> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\DiasHorario>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\DiasHorario>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\DiasHorario>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\DiasHorario> deleteManyOrFail(iterable $entities, array $options = [])
 */
class DiasHorariosTable extends Table
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

        $this->setTable('dias_horarios');
        $this->setDisplayField('ID');
        $this->setPrimaryKey('ID');

        $this->belongsTo('Dias', [
            'foreignKey' => 'diaID',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Horarios', [
            'foreignKey' => 'horarioID',
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
            ->integer('dia_id')
            ->notEmptyString('dia_id');

        $validator
            ->integer('horario_id')
            ->notEmptyString('horario_id');

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
        $rules->add($rules->existsIn(['dia_id'], 'Dias'), ['errorField' => 'dia_id']);
        $rules->add($rules->existsIn(['horario_id'], 'Horarios'), ['errorField' => 'horario_id']);

        return $rules;
    }
}
