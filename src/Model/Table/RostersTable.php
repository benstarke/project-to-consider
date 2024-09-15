<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Rosters Model
 *
 * @property \App\Model\Table\ShiftsTable&\Cake\ORM\Association\HasMany $Shifts
 *
 * @method \App\Model\Entity\Roster newEmptyEntity()
 * @method \App\Model\Entity\Roster newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Roster> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Roster get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Roster findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Roster patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Roster> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Roster|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Roster saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Roster>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Roster>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Roster>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Roster> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Roster>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Roster>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Roster>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Roster> deleteManyOrFail(iterable $entities, array $options = [])
 */
class RostersTable extends Table
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

        $this->setTable('rosters');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasMany('Shifts', [
            'foreignKey' => 'roster_id',
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
            ->maxLength('name', 55)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->date('end_date')
            ->requirePresence('end_date', 'create')
            ->notEmptyDate('end_date');

        $validator
            ->boolean('isDefault')
            ->notEmptyString('isDefault');

        $validator
            ->dateTime('create_time')
            ->allowEmptyDateTime('create_time');

        $validator
            ->dateTime('update_time')
            ->allowEmptyDateTime('update_time');

        $validator
            ->date('roster_date')
            ->requirePresence('roster_date', 'create')
            ->notEmptyDate('roster_date');

        return $validator;
    }
        public static $currentUserId;
    public function afterDelete($event, $entity, $options)
    {
        $entityName = 'Rosters';
        $message = " Deleted a Roster:  " . $entity->name;
        (new LogsTable())->saveLogs($message, $entityName, self::$currentUserId, $entity->id, 'deleted');
        return true;
    }

    public function afterSave($event, $entity, $options)
    {
        $entityName = 'Rosters';
        $logsTable =  (new LogsTable());
        $data =  [
            'id' => 'ID',
            'isDefault' => 'Is Default',
            'name' => 'Name',
            'end_date' => 'End Date',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'roster_date' => 'Roster Date',
        ];

       
        if ($entity->isNew()) {
            $message = " Created a new Roster: " . $entity->name;
            $logsTable->saveLogs($message, $entityName, self::$currentUserId, $entity->id, 'create');
        } else {
            
            if ($entity->isDirty()) {
                
                $originalData = $entity->extractOriginalChanged($entity->getDirty());
                    
                    $afterData = $entity->toArray();
                    
                    $editLog = " Edited a Roster:  " . $entity->name . ' Fields: ';
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

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->isUnique(['end_date', 'roster_date']), ['errorField' => 'end_date']);

        return $rules;
    }
    }
