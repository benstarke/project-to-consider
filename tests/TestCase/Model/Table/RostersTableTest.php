<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RostersTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RostersTable Test Case
 */
class RostersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\RostersTable
     */
    protected $Rosters;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Rosters',
        'app.Shifts',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Rosters') ? [] : ['className' => RostersTable::class];
        $this->Rosters = $this->getTableLocator()->get('Rosters', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Rosters);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\RostersTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
