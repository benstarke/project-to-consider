<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Logs Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\Log newEmptyEntity()
 * @method \App\Model\Entity\Log newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Log> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Log get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Log findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Log patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Log> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Log|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Log saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Log>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Log>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Log>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Log> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Log>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Log>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Log>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Log> deleteManyOrFail(iterable $entities, array $options = [])
 */
class LogsTable extends Table
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

        $this->setTable('logs');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
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
            ->scalar('message')
            ->maxLength('message', 255)
            ->allowEmptyString('message');

        $validator
            ->scalar('entity_name')
            ->maxLength('entity_name', 255)
            ->allowEmptyString('entity_name');

        $validator
            ->integer('user_id')
            ->allowEmptyString('user_id');

        $validator
            ->dateTime('createtime')
            ->allowEmptyDateTime('createtime');

        $validator
            ->scalar('action')
            ->maxLength('action', 255)
            ->allowEmptyString('action');

        $validator
            ->integer('entity_id')
            ->allowEmptyString('entity_id');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);

        return $rules;
    }
    public function saveLogs($message, $entity_name, $user_id, $entity_id,$action = null){
        $log = $this->newEntity([
           'message' => $message,
            'entity_name' => $entity_name,
            'user_id' => $user_id,
            'entity_id' => $entity_id,
            'action' => $action,
            'createtime' => date('Y-m-d H:i:s')
        ]);
        return $this->save($log);
    }
}
