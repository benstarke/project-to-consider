<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Shift Entity
 *
 * @property int $id
 * @property \Cake\I18n\DateTime|null $start_time
 * @property \Cake\I18n\DateTime|null $end_time
 * @property \Cake\I18n\DateTime|null $clock_in_time
 * @property \Cake\I18n\DateTime|null $clock_out_time
 * @property string|null $image
 * @property bool|null $isLeaves
 * @property int $roster_id
 * @property int $role_id
 * @property int $user_id
 * @property time|null $clock_hours
 *
 * @property \App\Model\Entity\Roster $roster
 * @property \App\Model\Entity\Role $role
 * @property \App\Model\Entity\User $user
 */
class Shift extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     * Setting '*' to true allows all unspecified fields to be mass assigned.
     * For security purposes, it is advised to set '*' to false (or remove it),
     * and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'start_time' => true,
        'end_time' => true,
        'clock_in_time' => true,
        'clock_out_time' => true,
        'clock_hours' => true,
        'image' => true,
        'isLeaves' => true,
        'roster_id' => true,
        'role_id' => true,
        'user_id' => true,
        'roster' => true,
        'role' => true,
        'user' => true,
    ];
}

