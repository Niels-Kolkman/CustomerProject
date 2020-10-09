<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TestHasGroupTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TestHasGroupTable Test Case
 */
class TestHasGroupTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TestHasGroupTable
     */
    protected $TestHasGroup;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.TestHasGroup',
        'app.Tests',
        'app.Groups',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('TestHasGroup') ? [] : ['className' => TestHasGroupTable::class];
        $this->TestHasGroup = $this->getTableLocator()->get('TestHasGroup', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->TestHasGroup);

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
