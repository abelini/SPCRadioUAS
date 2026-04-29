<?php
declare(strict_types=1);

namespace SPC\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * StreamHits Table
 *
 * @method \SPC\Model\Entity\StreamHit newEmptyEntity()
 * @method \SPC\Model\Entity\StreamHit newEntity(array $data, array $options = [])
 * @method array<\SPC\Model\Entity\StreamHit> newEntities(array $data, array $options = [])
 * @method \SPC\Model\Entity\StreamHit get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \SPC\Model\Entity\StreamHit findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \SPC\Model\Entity\StreamHit patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\SPC\Model\Entity\StreamHit> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \SPC\Model\Entity\StreamHit|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \SPC\Model\Entity\StreamHit saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\SPC\Model\Entity\StreamHit>|\Cake\Datasource\ResultSetInterface<\SPC\Model\Entity\StreamHit>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\SPC\Model\Entity\StreamHit> saveManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class StreamHitsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('stream_hits');
        $this->setDisplayField('format');
        $this->setPrimaryKey('ID');

        $this->addBehavior('Timestamp');
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator->scalar('format')->requirePresence('format', 'create')->notEmptyString('format');
        $validator->scalar('referer')->maxLength('referer', 255)->requirePresence('referer', 'create')->notEmptyString('referer');
        $validator->scalar('refererType')->requirePresence('refererType', 'create')->notEmptyString('refererType');
        $validator->scalar('ip')->maxLength('ip', 45)->requirePresence('ip', 'create')->notEmptyString('ip');
        $validator->scalar('userAgent')->maxLength('userAgent', 512)->requirePresence('userAgent', 'create')->notEmptyString('userAgent');
        $validator->scalar('country')->maxLength('country', 64)->allowEmptyString('country');
        $validator->scalar('countryCode')->maxLength('countryCode', 2)->allowEmptyString('countryCode');
        $validator->scalar('city')->maxLength('city', 64)->allowEmptyString('city');
        $validator->scalar('zip')->maxLength('zip', 10)->allowEmptyString('zip');
        $validator->decimal('lat')->allowEmptyString('lat');
        $validator->decimal('lon')->allowEmptyString('lon');

        return $validator;
    }
}