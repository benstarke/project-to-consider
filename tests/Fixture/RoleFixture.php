<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * RoleFixture
 */
class RoleFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'role';
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
                'name' => 'Lorem ipsum dolor sit amet',
                'eligible' => 'Lorem ipsum dolor sit amet',
                'isActive' => 1,
                'create_time' => '2024-03-13 01:55:18',
                'update_time' => '2024-03-13 01:55:18',
            ],
        ];
        parent::init();
    }
}
