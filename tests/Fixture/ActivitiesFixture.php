<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ActivitiesFixture
 */
class ActivitiesFixture extends TestFixture
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
                'description' => 'Lorem ipsum dolor sit amet',
                'isActive' => 1,
                'created_time' => '2024-03-14 04:36:48',
                'modified_time' => '2024-03-14 04:36:48',
                'role_id' => 1,
            ],
        ];
        parent::init();
    }
}
