<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * OperationsFixture
 */
class OperationsFixture extends TestFixture
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
                'day_name' => 'Lorem ipsum dolor ',
                'day_start' => '10:51:55',
                'day_end' => '10:51:55',
                'isActive' => 1,
            ],
        ];
        parent::init();
    }
}
