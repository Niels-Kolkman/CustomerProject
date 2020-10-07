<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TestHasGroup Model
 *
 * @property \App\Model\Table\TestsTable&\Cake\ORM\Association\BelongsTo $Tests
 * @property \App\Model\Table\GroupsTable&\Cake\ORM\Association\BelongsTo $Groups
 *
 * @method \App\Model\Entity\TestHasGroup newEmptyEntity()
 * @method \App\Model\Entity\TestHasGroup newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\TestHasGroup[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\TestHasGroup get($primaryKey, $options = [])
 * @method \App\Model\Entity\TestHasGroup findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\TestHasGroup patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\TestHasGroup[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\TestHasGroup|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TestHasGroup saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\TestHasGroup[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\TestHasGroup[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\TestHasGroup[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\TestHasGroup[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class TestHasGroupTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('test_has_group');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Tests', [
            'foreignKey' => 'tests_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Groups', [
            'foreignKey' => 'groups_id',
            'joinType' => 'INNER',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['tests_id'], 'Tests'), ['errorField' => 'tests_id']);
        $rules->add($rules->existsIn(['groups_id'], 'Groups'), ['errorField' => 'groups_id']);

        return $rules;
    }
}
