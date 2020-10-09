<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TestHasUserTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TestHasUserTable Test Case
 */
class TestHasUserTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TestHasUserTable
     */
    protected $TestHasUser;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.TestHasUser',
        'app.Tests',
        'app.Users',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('TestHasUser') ? [] : ['className' => TestHasUserTable::class];
        $this->TestHasUser = $this->getTableLocator()->get('TestHasUser', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->TestHasUser);

        parent::tearDown();
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
