<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Operations Model
 *
 * @method \App\Model\Entity\Operation newEmptyEntity()
 * @method \App\Model\Entity\Operation newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Operation> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Operation get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Operation findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Operation patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Operation> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Operation|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Operation saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Operation>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Operation>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Operation>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Operation> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Operation>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Operation>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Operation>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Operation> deleteManyOrFail(iterable $entities, array $options = [])
 */
class OperationsTable extends Table
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

        $this->setTable('operations');
        $this->setDisplayField('day_name');
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
            ->scalar('day_name')
            ->maxLength('day_name', 20)
            ->requirePresence('day_name', 'create')
            ->notEmptyString('day_name')
            ->add('day_name', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->time('day_start')
            ->allowEmptyTime('day_start');

        $validator
            ->time('day_end')
            ->allowEmptyTime('day_end');

        $validator
            ->boolean('isActive')
            ->notEmptyString('isActive');

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
        $rules->add($rules->isUnique(['day_name']), ['errorField' => 'day_name']);

        return $rules;
    }
}
