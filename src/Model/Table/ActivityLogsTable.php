<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ActivityLogs Model
 *
 * @method \App\Model\Entity\ActivityLog newEmptyEntity()
 * @method \App\Model\Entity\ActivityLog newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\ActivityLog> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ActivityLog get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\ActivityLog findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\ActivityLog patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\ActivityLog> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ActivityLog|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\ActivityLog saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\ActivityLog>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ActivityLog>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ActivityLog>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ActivityLog> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ActivityLog>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ActivityLog>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ActivityLog>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ActivityLog> deleteManyOrFail(iterable $entities, array $options = [])
 */
class ActivityLogsTable extends Table
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

        $this->setTable('activity_logs');
        $this->setDisplayField('scope_model');
        $this->setPrimaryKey('id');
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
            ->dateTime('created_at')
            ->notEmptyDateTime('created_at');

        $validator
            ->scalar('scope_model')
            ->maxLength('scope_model', 128)
            ->requirePresence('scope_model', 'create')
            ->notEmptyString('scope_model');

        $validator
            ->scalar('scope_id')
            ->maxLength('scope_id', 64)
            ->requirePresence('scope_id', 'create')
            ->notEmptyString('scope_id');

        $validator
            ->scalar('issuer_model')
            ->maxLength('issuer_model', 128)
            ->allowEmptyString('issuer_model');

        $validator
            ->scalar('issuer_id')
            ->maxLength('issuer_id', 64)
            ->allowEmptyString('issuer_id');

        $validator
            ->scalar('object_model')
            ->maxLength('object_model', 128)
            ->allowEmptyString('object_model');

        $validator
            ->scalar('object_id')
            ->maxLength('object_id', 64)
            ->allowEmptyString('object_id');

        $validator
            ->scalar('level')
            ->maxLength('level', 16)
            ->requirePresence('level', 'create')
            ->notEmptyString('level');

        $validator
            ->scalar('action')
            ->maxLength('action', 64)
            ->allowEmptyString('action');

        $validator
            ->scalar('message')
            ->allowEmptyString('message');

        $validator
            ->scalar('data')
            ->allowEmptyString('data');

        return $validator;
    }
}
