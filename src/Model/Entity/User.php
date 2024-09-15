<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Authentication\PasswordHasher\DefaultPasswordHasher;
use Cake\ORM\Entity;

/**
 * User Entity
 *
 * @property int $id
 * @property string $email
 * @property string $f_name
 * @property string $l_name
 * @property string $password
 * @property string|null $nonce
 * @property \Cake\I18n\DateTime|null $nonce_expiry
 * @property \Cake\I18n\DateTime|null $created
 * @property \Cake\I18n\DateTime|null $modified
 * @property int|null $gender
 * @property \Cake\I18n\Date|null $birthday
 * @property int $phone
 * @property string|null $avatarimg
 * @property bool $isManager
 * @property bool $isAdmin
 * @property bool $isEmployee
 * @property string $address
 *
 * @property \App\Model\Entity\Shift[] $shifts
 */
class User extends Entity
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
        'email' => true,
        'f_name' => true,
        'l_name' => true,
        'password' => true,
        'nonce' => true,
        'nonce_expiry' => true,
        'created' => true,
        'modified' => true,
        'gender' => true,
        'birthday' => true,
        'phone' => true,
        'avatarimg' => true,
        'isManager' => true,
        'isAdmin' => true,
        'isEmployee' => true,
        'address' => true,
        'shifts' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var list<string>
     */
    protected array $_hidden = [
        'password',
    ];

    protected function _setPassword(string $password): ?string
    {
        if (strlen($password) > 0) {
            return (new DefaultPasswordHasher())->hash($password);
        }

        return $password;
    }
}
