<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TestHasGroup Entity
 *
 * @property int $id
 * @property int $tests_id
 * @property int $groups_id
 *
 * @property \App\Model\Entity\Test $test
 * @property \App\Model\Entity\Group $group
 */
class TestHasGroup extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'tests_id' => true,
        'groups_id' => true,
        'test' => true,
        'group' => true,
    ];
}
