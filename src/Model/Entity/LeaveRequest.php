<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LeaveRequest Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string $leave_type
 * @property \Cake\I18n\Date $start_date
 * @property \Cake\I18n\Date $end_date
 * @property string|null $reason
 * @property string|null $status
 * @property string|null $manager_comments
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\User $user
 */
class LeaveRequest extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'user_id' => true,
        'leave_type' => true,
        'start_date' => true,
        'end_date' => true,
        'reason' => true,
        'status' => true,
        'manager_comments' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
    ];
}
