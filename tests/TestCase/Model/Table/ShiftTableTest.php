<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ShiftTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ShiftTable Test Case
 */
class ShiftTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ShiftTable
     */
    protected $Shift;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Shift',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Shift') ? [] : ['className' => ShiftTable::class];
        $this->Shift = $this->getTableLocator()->get('Shift', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Shift);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ShiftTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
