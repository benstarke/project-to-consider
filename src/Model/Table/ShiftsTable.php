<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Elastic\ActivityLogger\Model\Entity\ActivityLog;

/**
 * Shifts Model
 *
 * @property \App\Model\Table\RostersTable&\Cake\ORM\Association\BelongsTo $Rosters
 * @property \App\Model\Table\RolesTable&\Cake\ORM\Association\BelongsTo $Roles
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\Shift newEmptyEntity()
 * @method \App\Model\Entity\Shift newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Shift> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Shift get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Shift findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Shift patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Shift> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Shift|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Shift saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Shift>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Shift>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Shift>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Shift> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Shift>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Shift>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Shift>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Shift> deleteManyOrFail(iterable $entities, array $options = [])
 */
class ShiftsTable extends Table
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

        $this->setTable('shifts');
        $this->setDisplayField('image');
        $this->setPrimaryKey('id');

        $this->belongsTo('Rosters', [
            'foreignKey' => 'roster_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Roles', [
            'foreignKey' => 'role_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('Tasks', [
            'foreignKey' => 'shift_id',
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
            ->dateTime('start_time')
            ->notEmptyDateTime('start_time');

        $validator
            ->dateTime('end_time')
            ->notEmptyDateTime('end_time');

        $validator
            ->scalar('image')
            ->maxLength('image', 255)
            ->allowEmptyFile('image');

        $validator
            ->boolean('isLeaves')
            ->allowEmptyString('isLeaves');

        $validator
            ->integer('roster_id')
            ->notEmptyString('roster_id');

        $validator
            ->integer('role_id')
            ->notEmptyString('role_id');

        $validator
            ->integer('user_id')
            ->notEmptyString('user_id');

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
        $rules->add($rules->existsIn(['roster_id'], 'Rosters'), ['errorField' => 'roster_id']);
        $rules->add($rules->existsIn(['role_id'], 'Roles'), ['errorField' => 'role_id']);
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);

        return $rules;
    }
    public static $currentUserId;
    public function afterDelete($event, $entity, $options)
    {
        $entityName = 'Shifts';
        $roster_info = (new RostersTable())->get(['id' => $entity->roster_id])->toArray();
        $user_info = (new UsersTable())->get(['id' => $entity->user_id])->toArray();
        $message = " Deleted a Shift:" .$roster_info['name'] . $entity->start_time. ' To '. $entity->end_time.' User :'.$user_info['f_name'];
        (new LogsTable())->saveLogs($message, $entityName, self::$currentUserId, $entity->id, 'deleted');
        return true;
    }

    public function afterSave($event, $entity, $options)
    {
        $entityName = 'Shifts';
        $logsTable =  (new LogsTable());
        $data =  [
           'id' => 'id',
           'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'name' => 'Shift Name',
            'image' => 'Image',
            'isLeaves' => 'Is Leaves',
            'roster_id' => 'Roster Id',
            'role_id' => 'Role Id',
            'user_id' => 'User Id',
        ];
        $user_info = (new UsersTable())->get(['id' => $entity->user_id])->toArray();
        $roster_info = (new RostersTable())->get(['id' => $entity->roster_id])->toArray();
        
        if ($entity->isNew()) {
            $message = " Created a new Shift:" . $roster_info['name'] . $entity->start_time. ' To '. $entity->end_time .' User :'.$user_info['f_name'];
            $logsTable->saveLogs($message, $entityName, self::$currentUserId, $entity->id, 'create');
         
        } else {
            
            if ($entity->isDirty()) {
               
                $originalData = $entity->extractOriginalChanged($entity->getDirty());
                
                $afterData = $entity->toArray();
                
                $editLog = "  Edited a Shift:" .$roster_info['name'] . $entity->start_time. ' To '. $entity->end_time . ' Fields: ';
                foreach ($originalData as $field => $value) {
                    if (isset($afterData[$field])) {
                        if ($field=='user_id') {
                            $old_user_info = (new UsersTable())->get(['id' => $originalData[$field]])->toArray();
                            $editLog .= "$data[$field]: {$old_user_info["f_name"]} Updated to {$user_info["f_name"]}\n";
                        }else{
                            $editLog .= "$data[$field]: $value Updated to {$afterData[$field]}\n";
                        }
                    }
                }
                $logsTable->saveLogs($editLog, $entityName, self::$currentUserId, $entity->id, 'update');
            }
        }

        return true;
    }

}
