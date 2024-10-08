<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Role Entity
 *
 * @property int $id
 * @property string $name
 * @property string $eligible
 * @property bool $isActive
 * @property \Cake\I18n\DateTime $create_time
 * @property \Cake\I18n\DateTime $update_time
 *
 * @property \App\Model\Entity\Activity[] $activities
 * @property \App\Model\Entity\Shift[] $shifts
 */
class Role extends Entity
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
        'name' => true,
        'eligible' => true,
        'isActive' => true,
        'create_time' => true,
        'update_time' => true,
        'activities' => true,
        'shifts' => true,
    ];
}
