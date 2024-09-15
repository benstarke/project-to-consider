<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Activities Model
 *
 * @property \App\Model\Table\RolesTable&\Cake\ORM\Association\BelongsTo $Roles
 *
 * @method \App\Model\Entity\Activity newEmptyEntity()
 * @method \App\Model\Entity\Activity newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Activity> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Activity get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Activity findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Activity patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Activity> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Activity|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Activity saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Activity>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Activity>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Activity>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Activity> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Activity>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Activity>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Activity>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Activity> deleteManyOrFail(iterable $entities, array $options = [])
 */
class ActivitiesTable extends Table
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

        $this->setTable('activities');
        $this->setDisplayField('description');
        $this->setPrimaryKey('id');

        $this->belongsTo('Roles', [
            'foreignKey' => 'role_id',
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
            ->scalar('description')
            ->maxLength('description', 255)
            ->requirePresence('description', 'create')
            ->notEmptyString('description');

        $validator
            ->boolean('isActive')
            ->notEmptyString('isActive');

        $validator
            ->dateTime('created_time')
            ->notEmptyDateTime('created_time');

        $validator
            ->dateTime('modified_time')
            ->notEmptyDateTime('modified_time');

        $validator
            ->integer('role_id')
            ->notEmptyString('role_id');

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
        $rules->add($rules->existsIn(['role_id'], 'Roles'), ['errorField' => 'role_id']);

        return $rules;
    }

    public static $currentUserId;
    public function afterDelete($event, $entity, $options)
    {
        $entityName = 'Activities';
        $message = " Deleted a Activitie:  " . $entity->description;
        (new LogsTable())->saveLogs($message, $entityName, self::$currentUserId, $entity->id, 'deleted');
        return true;
    }

    public function afterSave($event, $entity, $options)
    {
        $entityName = 'Tasks';
        $logsTable =  (new LogsTable());
        $data = [
            'description' => 'description',
            'created_time' => 'created_time',
            'modified_time' =>'modified_time',
            'isActive' => 'isActive',
            'role_id' => 'role_id',
        ];

        
        if ($entity->isNew()) {
            $message = " Created a new Activitie: " . $entity->description;
            $logsTable->saveLogs($message, $entityName, self::$currentUserId, $entity->id, 'create');
        } else {
            
            if ($entity->isDirty()) {
                $originalData = $entity->extractOriginalChanged($entity->getDirty());
                $afterData = $entity->toArray();
                $editLog = " Edited a Activitie:  " . $entity->description . ' Fields: ';
                foreach ($originalData as $field => $value) {
                    if (isset($afterData[$field])) {
                        $editLog .= "$data[$field]: $value Updated to {$afterData[$field]}\n";
                    }
                }
                $logsTable->saveLogs($editLog, $entityName, self::$currentUserId, $entity->id, 'update');
            }
        }

        return true;
    }
}
