<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Roster Entity
 *
 * @property int $id
 * @property string $name
 * @property bool $isDefault
 * @property \Cake\I18n\DateTime|null $create_time
 * @property \Cake\I18n\DateTime|null $update_time
 * @property \Cake\I18n\Date $roster_date
 * @property \Cake\I18n\Date $end_date
 *
 * @property \App\Model\Entity\Shift[] $shifts
 */
class Roster extends Entity
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
        'isDefault' => true,
        'name' => true,
        'create_time' => true,
        'update_time' => true,
        'roster_date' => true,
        'end_date' => true,
        'shifts' => true,
    ];
}
