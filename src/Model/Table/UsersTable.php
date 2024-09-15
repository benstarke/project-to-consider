<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \App\Model\Table\ShiftsTable&\Cake\ORM\Association\HasMany $Shifts
 * @method \App\Model\Entity\User newEmptyEntity()
 * @method \App\Model\Entity\User newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\User> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\User findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\User> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\User>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\User>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\User>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\User> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\User>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\User>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\User>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\User> deleteManyOrFail(iterable $entities, array $options = [])
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class UsersTable extends Table
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

        $this->setTable('users');
        $this->setDisplayField('firstName');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Shifts', [
            'foreignKey' => 'user_id',
        ]);

        $this->hasOne('Availabilities', [
            'foreignKey' => 'user_id',
            'dependent' => true,
                'propertyName' => 'availability', // Add this line for clarity

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
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email');

        $validator
            ->scalar('f_name')
            ->maxLength('f_name', 55)
            ->requirePresence('f_name', 'create')
            ->notEmptyString('f_name');

        $validator
            ->scalar('l_name')
            ->maxLength('l_name', 55)
            ->requirePresence('l_name', 'create')
            ->notEmptyString('l_name');

        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->requirePresence('password', 'create')
            ->notEmptyString('password');

        $validator
            ->scalar('nonce')
            ->maxLength('nonce', 255)
            ->allowEmptyString('nonce');

        $validator
            ->dateTime('nonce_expiry')
            ->allowEmptyDateTime('nonce_expiry');

        $validator
            ->integer('gender')
            ->allowEmptyString('gender');

        $validator
            ->date('birthday')
            ->allowEmptyDate('birthday');

        $validator
            ->integer('phone')
            ->requirePresence('phone', 'create')
            ->notEmptyString('phone');

        $validator
            ->scalar('avatarimg')
            ->maxLength('avatarimg', 255)
            ->requirePresence('avatarimg', 'create')
            ->allowEmptyString('avatarimg');

        $validator
            ->boolean('isManager')
            ->notEmptyString('isManager');

        $validator
            ->boolean('isAdmin')
            ->notEmptyString('isAdmin');

        $validator
            ->boolean('isEmployee')
            ->notEmptyString('isEmployee');

        $validator
            ->scalar('address')
            ->maxLength('address', 255)
            ->requirePresence('address', 'create')
            ->notEmptyString('address');

        return $validator;
    }

    public function validationResetPassword(Validator $validator): Validator
    {
        $validator
            ->notEmptyString('password', 'Please enter a new password.');

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
        $rules->add($rules->isUnique(['email']), ['errorField' => 'email']);

        return $rules;
    }


    public static $currentUserId;
    public function afterDelete($event, $entity, $options)
    {
        $entityName = 'Activities';
        $message = " Deleted a User:  " . $entity->f_name . " " . $entity->l_name;
        (new LogsTable())->saveLogs($message, $entityName, self::$currentUserId, $entity->id, 'deleted');
        return true;
    }

    public function afterSave($event, $entity, $options)
    {
        $entityName = 'Users';
        $logsTable =  (new LogsTable());
        $data = [
            'email' => 'Email',
            'f_name' => 'First Name',
            'l_name' => 'Last Name',
            'password' => 'Password',
            'nonce' => 'Nonce',
            'nonce_expiry' => 'Nonce Expiry',
            'gender' => 'Gender',
            'birthday' => 'Birthday',
            'phone' => 'Phone',
            'avatarimg' => 'Avatar Image',
            'isManager' => 'Is Manager',
            'isAdmin' => 'Is Admin',
            'isEmployee' => 'Is Employee',
            'address' => 'Address',
            'modified'=> 'Modified',
            'created' => 'Created',
        ];

        
        if ($entity->isNew()) {
            $message = " Created a new User: " . $entity->f_name . " " . $entity->l_name;
            $logsTable->saveLogs($message, $entityName, self::$currentUserId, $entity->id, 'create');
        } else {
            
            if ($entity->isDirty()) {
                $originalData = $entity->extractOriginalChanged($entity->getDirty());
                $afterData = $entity->toArray();
                $editLog = " Edited a User:  " . $entity->f_name . " " . $entity->l_name . ' Fields: ';
                foreach ($originalData as $field => $value) {
                    if (isset($afterData[$field])) {
                        if($field=='isManager' || $field=='isAdmin' || $field=='isEmployee'){
                            if($afterData[$field]==1){
                                $editLog .= "$data[$field]: NO Updated to YES \n";
                            }else if($afterData[$field]==0){
                                $editLog .= "$data[$field]: YES Updated to NO \n";
                            }
                            continue;
                        }
                            $editLog .= "$data[$field]: $value Updated to {$afterData[$field]}\n";
                    }
                }
                $logsTable->saveLogs($editLog, $entityName, self::$currentUserId, $entity->id, 'update');
            }
        }

        return true;
    }
}
