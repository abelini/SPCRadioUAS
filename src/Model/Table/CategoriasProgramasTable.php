<?php
declare(strict_types=1);

namespace SPC\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * CategoriasProgramas Model
 *
 * @method \SPC\Model\Entity\CategoriasPrograma newEmptyEntity()
 * @method \SPC\Model\Entity\CategoriasPrograma newEntity(array $data, array $options = [])
 * @method array<\SPC\Model\Entity\CategoriasPrograma> newEntities(array $data, array $options = [])
 * @method \SPC\Model\Entity\CategoriasPrograma get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \SPC\Model\Entity\CategoriasPrograma findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \SPC\Model\Entity\CategoriasPrograma patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\SPC\Model\Entity\CategoriasPrograma> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \SPC\Model\Entity\CategoriasPrograma|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \SPC\Model\Entity\CategoriasPrograma saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\SPC\Model\Entity\CategoriasPrograma>|\Cake\Datasource\ResultSetInterface<\SPC\Model\Entity\CategoriasPrograma>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\SPC\Model\Entity\CategoriasPrograma>|\Cake\Datasource\ResultSetInterface<\SPC\Model\Entity\CategoriasPrograma> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\SPC\Model\Entity\CategoriasPrograma>|\Cake\Datasource\ResultSetInterface<\SPC\Model\Entity\CategoriasPrograma>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\SPC\Model\Entity\CategoriasPrograma>|\Cake\Datasource\ResultSetInterface<\SPC\Model\Entity\CategoriasPrograma> deleteManyOrFail(iterable $entities, array $options = [])
 */
class CategoriasProgramasTable extends Table
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

        $this->setTable('categorias_programas');
        $this->setDisplayField('name');
        $this->setPrimaryKey('ID');

        $this->hasMany('Programas', [
            'foreignKey' => 'categoryID',
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
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('slug')
            ->maxLength('slug', 255)
            ->requirePresence('slug', 'create')
            ->notEmptyString('slug');

        $validator
            ->scalar('icon')
            ->maxLength('icon', 128)
            ->requirePresence('icon', 'create')
            ->notEmptyString('icon');

        return $validator;
    }
}
