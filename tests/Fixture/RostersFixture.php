<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * RostersFixture
 */
class RostersFixture extends TestFixture
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
                'isDefault' => 1,
                'create_time' => '2024-03-18 09:03:25',
                'update_time' => '2024-03-18 09:03:25',
                'roster_date' => '2024-03-18',
            ],
        ];
        parent::init();
    }
}
