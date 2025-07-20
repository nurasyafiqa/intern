<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SupervisorsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SupervisorsTable Test Case
 */
class SupervisorsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SupervisorsTable
     */
    protected $Supervisors;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Supervisors',
        'app.Companies',
        'app.Applications',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Supervisors') ? [] : ['className' => SupervisorsTable::class];
        $this->Supervisors = $this->getTableLocator()->get('Supervisors', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Supervisors);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\SupervisorsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\SupervisorsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
