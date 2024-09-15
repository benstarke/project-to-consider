<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ShiftsFixture
 */
class ShiftsFixture extends TestFixture
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
                'start_time' => 1710753144,
                'end_time' => 1710753144,
                'image' => 'Lorem ipsum dolor sit amet',
                'isLeaves' => 1,
                'roster_id' => 1,
                'role_id' => 1,
                'user_id' => 1,
            ],
        ];
        parent::init();
    }
}
