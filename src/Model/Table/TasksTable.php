<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Tasks Model
 *
 * @property \App\Model\Table\ShiftsTable&\Cake\ORM\Association\BelongsTo $Shifts
 *
 * @method \App\Model\Entity\Task newEmptyEntity()
 * @method \App\Model\Entity\Task newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Task> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Task get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Task findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Task patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Task> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Task|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Task saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Task>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Task>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Task>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Task> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Task>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Task>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Task>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Task> deleteManyOrFail(iterable $entities, array $options = [])
 */
class TasksTable extends Table
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

        $this->setTable('tasks');
        $this->setDisplayField('description');
        $this->setPrimaryKey('id');

        $this->belongsTo('Shifts', [
            'foreignKey' => 'shift_id',
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
            ->scalar('status')
            ->requirePresence('status', 'create')
            ->notEmptyString('status');

        $validator
            ->dateTime('deadline')
            ->requirePresence('deadline', 'create')
            ->notEmptyDateTime('deadline');
        
        $validator
            ->scalar('responsibility')
            ->maxLength('responsibility', 255)
            ->allowEmptyString('responsibility'); 
        
        $validator
            ->integer('shift_id')
            ->notEmptyString('shift_id');

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
        $rules->add($rules->existsIn(['shift_id'], 'Shifts'), ['errorField' => 'shift_id']);

        return $rules;
    }



    public static $currentUserId;
    public function afterDelete($event, $entity, $options)
    {
        $entityName = 'Rosters';
        $message = " Deleted a Task:  " . $entity->description;
        (new LogsTable())->saveLogs($message, $entityName, self::$currentUserId, $entity->id, 'deleted');
        return true;
    }

    public function afterSave($event, $entity, $options)
    {
        $entityName = 'Tasks';
        $logsTable = new LogsTable();

        $data = [
            'name' => 'name',
            'description' => 'description',
            'deadline' => 'deadline',
            'status' => 'status',
            'shift_id' => 'shift_id',
            'responsibility' => 'responsibility',
            'description_color' => 'description_color' 
        ];

        if ($entity->isNew()) {
            $message = "Created a new Task: " . $entity->description;
            $logsTable->saveLogs($message, $entityName, self::$currentUserId, $entity->id, 'create');
        } else {
            if ($entity->isDirty()) {
                $originalData = $entity->extractOriginalChanged($entity->getDirty());
                $afterData = $entity->toArray();
                $editLog = "Edited a Task: " . $entity->description . ' Fields: ';
                foreach ($originalData as $field => $value) {
                    if (isset($afterData[$field])) {
                        $editLog .= "{$data[$field]}: $value Updated to {$afterData[$field]}\n";
                    }
                }
                $logsTable->saveLogs($editLog, $entityName, self::$currentUserId, $entity->id, 'update');
            }
        }

        return true;
    }

}


