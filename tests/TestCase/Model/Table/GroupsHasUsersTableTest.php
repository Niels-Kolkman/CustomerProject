<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\GroupsHasUsersTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\GroupsHasUsersTable Test Case
 */
class GroupsHasUsersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\GroupsHasUsersTable
     */
    protected $GroupsHasUsers;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.GroupsHasUsers',
        'app.Groups',
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
        $config = $this->getTableLocator()->exists('GroupsHasUsers') ? [] : ['className' => GroupsHasUsersTable::class];
        $this->GroupsHasUsers = $this->getTableLocator()->get('GroupsHasUsers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->GroupsHasUsers);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
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
