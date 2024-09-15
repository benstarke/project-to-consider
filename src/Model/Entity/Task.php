<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Task Entity
 *
 * @property int $id
 * @property string $description
 * @property string $responsibility
 * @property string $status
 * @property \Cake\I18n\DateTime $deadline
 * @property int $shift_id
 *
 * @property \App\Model\Entity\Shift $shift
 */
class Task extends Entity
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
        'status' => true,
        'deadline' => true,
        'shift_id' => true,
        'shift' => true,
        'responsibility' => true, 
        'description_color' => true, 
        'user_id' => true,
    ];    
}


