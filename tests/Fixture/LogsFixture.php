<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * LogsFixture
 */
class LogsFixture extends TestFixture
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
                'message' => 'Lorem ipsum dolor sit amet',
                'entity_name' => 'Lorem ipsum dolor sit amet',
                'user_id' => 1,
                'createtime' => '2024-08-13 17:53:15',
                'action' => 'Lorem ipsum dolor sit amet',
                'entity_id' => 1,
            ],
        ];
        parent::init();
    }
}