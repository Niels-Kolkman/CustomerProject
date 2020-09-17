<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TestHasUserFixture
 */
class TestHasUserFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'test_has_user';
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'tests_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'users_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'tests' => ['type' => 'index', 'columns' => ['tests_id'], 'length' => []],
            'users' => ['type' => 'index', 'columns' => ['users_id'], 'length' => []],
        ],
        '_constraints' => [
            'tests' => ['type' => 'foreign', 'columns' => ['tests_id'], 'references' => ['tests', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'users' => ['type' => 'foreign', 'columns' => ['users_id'], 'references' => ['users', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8mb4_general_ci'
        ],
    ];
    // phpcs:enable
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'tests_id' => 1,
                'users_id' => 1,
            ],
        ];
        parent::init();
    }
}
