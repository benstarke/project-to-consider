<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RosterTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RosterTable Test Case
 */
class RosterTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\RosterTable
     */
    protected $Roster;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Roster',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Roster') ? [] : ['className' => RosterTable::class];
        $this->Roster = $this->getTableLocator()->get('Roster', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Roster);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\RosterTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
