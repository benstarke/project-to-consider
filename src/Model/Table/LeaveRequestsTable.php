<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LeaveRequests Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \App\Model\Entity\LeaveRequest newEmptyEntity()
 * @method \App\Model\Entity\LeaveRequest newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\LeaveRequest> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LeaveRequest get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\LeaveRequest findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\LeaveRequest patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\LeaveRequest> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\LeaveRequest|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\LeaveRequest saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\LeaveRequest>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LeaveRequest>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\LeaveRequest>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LeaveRequest> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\LeaveRequest>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LeaveRequest>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\LeaveRequest>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\LeaveRequest> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LeaveRequestsTable extends Table
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

        $this->setTable('leave_requests');
        $this->setDisplayField('leave_type');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
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
        ->integer('user_id')
        ->notEmptyString('user_id', 'User ID is required.');

    $validator
        ->scalar('leave_type')
        ->requirePresence('leave_type', 'create')
        ->notEmptyString('leave_type', 'Leave type is required.')
        ->add('leave_type', 'validValue', [
            'rule' => ['inList', ['vacation', 'sick', 'personal']],
            'message' => 'Please enter a valid leave type.'
        ]);

    $validator
        ->date('start_date')
        ->requirePresence('start_date', 'create')
        ->notEmptyDate('start_date', 'Start date is required.')
        ->add('start_date', 'validRange', [
            'rule' => function ($value, $context) {
                $endDate = $context['data']['end_date'] ?? null;
                return !$endDate || $value <= $endDate;
            },
            'message' => 'Start date must be on or before the end date.'
        ]);

    $validator
        ->date('end_date')
        ->requirePresence('end_date', 'create')
        ->notEmptyDate('end_date', 'End date is required.')
        ->add('end_date', 'validRange', [
            'rule' => function ($value, $context) {
                $startDate = $context['data']['start_date'] ?? null;
                return !$startDate || $value >= $startDate;
            },
            'message' => 'End date must be on or after the start date.'
        ]);

    $validator
        ->scalar('reason')
        ->allowEmptyString('reason')
        ->maxLength('reason', 255, 'Reason cannot exceed 255 characters.');

    $validator
        ->scalar('status')
        ->notEmptyString('status', 'Status is required.')
        ->add('status', 'validValue', [
            'rule' => ['inList', ['pending', 'approved', 'denied']],
            'message' => 'Please enter a valid status.'
        ]);

    $validator
        ->scalar('manager_comments')
        ->allowEmptyString('manager_comments')
        ->maxLength('manager_comments', 255, 'Manager comments cannot exceed 255 characters.');

    return $validator;
}

public function findPendingRequests(SelectQuery $query, array $options)
    {
        return $query->where(['LeaveRequests.status' => 'pending'])
                     ->contain(['Users' => function ($q) {
                         return $q->select(['id', 'firstName', 'lastName', 'email']); // Adjust these fields based on your Users table structure
                     }])
                     ->order(['LeaveRequests.created' => 'DESC']);
    }

}
