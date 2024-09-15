<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * RosterFixture
 */
class RosterFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'roster';
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
                'date_start' => '2024-03-13',
                'date_end' => '2024-03-13',
                'isDefault' => 1,
                'create_time' => '2024-03-13 01:55:37',
                'update_time' => '2024-03-13 01:55:37',
            ],
        ];
        parent::init();
    }
}
