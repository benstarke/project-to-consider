<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ShiftFixture
 */
class ShiftFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'shift';
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
                'start_date' => '2024-03-13 01:55:48',
                'end_date' => '2024-03-13',
                'meal_start' => '2024-03-13 01:55:48',
                'meal_end' => '2024-03-13 01:55:48',
                'create_time' => '2024-03-13 01:55:48',
                'update_time' => '2024-03-13 01:55:48',
                'image' => 'Lorem ipsum dolor sit amet',
                'isLeaves' => 1,
            ],
        ];
        parent::init();
    }
}
