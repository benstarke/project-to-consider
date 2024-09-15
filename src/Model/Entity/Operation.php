<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Operation Entity
 *
 * @property int $id
 * @property string $day_name
 * @property \Cake\I18n\Time|null $day_start
 * @property \Cake\I18n\Time|null $day_end
 * @property bool $isActive
 */
class Operation extends Entity
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
        'day_name' => true,
        'day_start' => true,
        'day_end' => true,
        'isActive' => true,
    ];
}
