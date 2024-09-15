<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Activity Entity
 *
 * @property int $id
 * @property string $description
 * @property bool $isActive
 * @property \Cake\I18n\DateTime $created_time
 * @property \Cake\I18n\DateTime $modified_time
 * @property int $role_id
 *
 * @property \App\Model\Entity\Role $role
 */
class Activity extends Entity
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
        'description' => true,
        'isActive' => true,
        'created_time' => true,
        'modified_time' => true,
        'role_id' => true,
        'role' => true,
    ];
}
