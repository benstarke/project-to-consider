<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Log Entity
 *
 * @property int $id
 * @property string|null $message
 * @property string|null $entity_name
 * @property int|null $user_id
 * @property \Cake\I18n\DateTime|null $createtime
 * @property string|null $action
 * @property int|null $entity_id
 *
 * @property \App\Model\Entity\User $user
 */
class Log extends Entity
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
        'message' => true,
        'entity_name' => true,
        'user_id' => true,
        'createtime' => true,
        'action' => true,
        'entity_id' => true,
        'user' => true,
    ];
}
