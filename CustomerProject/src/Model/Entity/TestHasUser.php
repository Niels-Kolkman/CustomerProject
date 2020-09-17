<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * TestHasUser Entity
 *
 * @property int $tests_id
 * @property int $users_id
 *
 * @property \App\Model\Entity\Test $test
 * @property \App\Model\Entity\User $user
 */
class TestHasUser extends Entity
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
        'users_id' => true,
        'test' => true,
        'user' => true,
    ];
}
