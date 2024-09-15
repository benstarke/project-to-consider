<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersFixture
 */
class UsersFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'email' => 'Lorem ipsum dolor sit amet',
                'f_name' => 'Lorem ipsum dolor sit amet',
                'l_name' => 'Lorem ipsum dolor sit amet',
                'password' => 'Lorem ipsum dolor sit amet',
                'nonce' => 'Lorem ipsum dolor sit amet',
                'nonce_expiry' => '2024-03-14 11:34:12',
                'created' => '2024-03-14 11:34:12',
                'modified' => '2024-03-14 11:34:12',
                'gender' => 1,
                'birthday' => '2024-03-14',
                'phone' => 1,
                'avatarimg' => 'Lorem ipsum dolor sit amet',
                'isManager' => 1,
                'isAdmin' => 1,
                'isEmployee' => 1,
                'address' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
