<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TestHasGroupFixture
 */
class TestHasGroupFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'test_has_group';
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'tests_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'groups_id' => ['type' => 'integer', 'length' => null, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'tests_id' => ['type' => 'index', 'columns' => ['tests_id'], 'length' => []],
            'groups' => ['type' => 'index', 'columns' => ['groups_id'], 'length' => []],
        ],
        '_constraints' => [
            'groups' => ['type' => 'foreign', 'columns' => ['groups_id'], 'references' => ['groups', 'id'], 'update' => 'noAction', 'delete' => 'noAction', 'length' => []],
            'tests_id' => ['type' => 'foreign', 'columns' => ['tests_id'], 'references' => ['tests', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
                'groups_id' => 1,
            ],
        ];
        parent::init();
    }
}
