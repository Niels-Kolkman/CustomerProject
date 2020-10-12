<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;

/**
 * Tests Controller
 *
 * @property \App\Model\Table\TestsTable $Tests
 * @method \App\Model\Entity\Test[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TestsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $session = $this->getRequest()->getSession();
        $testHasGroupTable = TableRegistry::getTableLocator()->get('TestHasGroup');
        $testHasUserTable = TableRegistry::getTableLocator()->get('TestHasUser');
        $groupsHasUserTable = TableRegistry::getTableLocator()->get('GroupsHasUsers');
        if ($session->read('Auth.role') == 'docent'){
            $tests = $this->paginate($this->Tests->find());
        }else{
          $groups = $groupsHasUserTable->find()
                ->where([
                'users_id' => $session->read('Auth.id')
                ])
                ->toArray();

          $testIdsGroups = $testHasGroupTable->find()
              ->where([
                  'groups_id IN' => array_column($groups, 'groups_id')
              ])->toArray();

          $ids = array_column($testIdsGroups, 'tests_id');

            $testIdsUsers =
                $testHasUserTable->find()
                ->where([
                    'users_id' => $session->read('Auth.id')
                ])->toArray();

            $allIds = array_merge(array_column($testIdsUsers, 'tests_id'), $ids);

            $tests = $this->paginate($this->Tests->find()->where([
               'id IN' =>  $allIds
            ]));
        }

        $this->set(compact('tests'));
    }

    /**
     * View method
     *
     * @param string|null $id Test id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $test = $this->Tests->get($id, [
            'contain' => [],
        ]);
        $testHasGroupsTable = TableRegistry::getTableLocator()->get('testHasGroup');
        $testHasUserTable = TableRegistry::getTableLocator()->get('testHasUser');

        $selectedGroups = $testHasGroupsTable->find()
            ->where([
                'tests_id' => $id
            ])
            ->contain('Groups')
            ->toArray();

        $selectedUsers = $testHasUserTable->find()
            ->where([
                'tests_id' => $id
            ])
            ->contain('Users')
            ->orderAsc('firstname')
            ->toArray();

        $this->set(compact('test'));
        $this->set(compact('selectedGroups'));
        $this->set(compact('selectedUsers'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $session = $this->getRequest()->getSession();
        if ($session->read('Auth.role') == 'student'){
            $this->Flash->error('You are not allowed here.');
            $this->redirect($this->referer('/tests'));
        }

        $usersTable = TableRegistry::getTableLocator()->get('Users');
        $users = $usersTable
            ->find('list', [ 'keyField' => 'id',
                'valueField' => function ($e) {
                    return $e->get('firstname'). ' ' . $e->get('lastname');
                }])
            ->where([
                'role' => 'student'
            ])
            ->orderAsc('firstname')
            ->toArray();

        $groupsTable = TableRegistry::getTableLocator()->get('groups');
        $groups = $groupsTable->find('list', [ 'keyField' => 'id', 'valueField' => 'group_name'])->orderAsc('group_name')->toArray();

        $test = $this->Tests->newEmptyEntity();
        $allTests = $this->Tests->find()->toArray();

        if ($this->request->is('post')) {
            $test = $this->Tests->patchEntity($test, $this->request->getData());

            if (array_search($this->request->getData('name'), $allTests) === false) {

                if ($this->Tests->save($test)) {
                    $this->Flash->success(__('The test has been saved.'));
                } else {
                    $this->Flash->error(__('The test could not be saved. Please, try again.'));
                    return $this->redirect(['action' => 'index']);
                }


                $newTest = $this->Tests->find()
                    ->where([
                        'name' => $this->request->getData('name'),
                    ])
                    ->first();


                if (!empty($this->request->getData('group_id'))) {
                    $testHasGroupsTable = TableRegistry::getTableLocator()->get('testHasGroup');
                    $groups = $this->request->getData('group_id');
                    foreach ($groups as $group) {
                        $testHasGroups = $testHasGroupsTable->newEmptyEntity();
                        $data = ['groups_id' => (int)$group, 'tests_id' => $newTest['id']];
                        $newTestHasGroups = $testHasGroupsTable->patchEntity($testHasGroups, $data);
                        $testHasGroupsTable->save($newTestHasGroups);
                    }
                }
                if (!empty($this->request->getData('user_id'))) {
                    $testHasUserTable = TableRegistry::getTableLocator()->get('testHasUser');
                    $students = $this->request->getData('user_id');
                    foreach ($students as $student) {
                        $testHasUser = $testHasUserTable->newEmptyEntity();
                        $data = ['users_id' => $student, 'tests_id' => $newTest['id']];
                        $newTestHasUsers = $testHasUserTable->patchEntity($testHasUser, $data);
                        $testHasUserTable->save($newTestHasUsers);
                    }
                }
                return $this->redirect(['action' => 'index']);
            }
            else {
                $this->Flash->error(__('The test could not be saved. The name is already used. Please, try again.'));
                return $this->redirect(['action' => 'index']);
            }
        }

        $this->set(compact('users'));
        $this->set(compact('test'));
        $this->set(compact('groups'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Test id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $usersTable = TableRegistry::getTableLocator()->get('Users');
        $testHasGroupsTable = TableRegistry::getTableLocator()->get('testHasGroup');
        $testHasUserTable = TableRegistry::getTableLocator()->get('testHasUser');
        $groupsTable = TableRegistry::getTableLocator()->get('groups');

        $session = $this->getRequest()->getSession();
        if ($session->read('Auth.role') == 'student'){
            $this->Flash->error('You are not allowed here.');
            $this->redirect($this->referer('/tests'));
        }

        $selectedGroups = $testHasGroupsTable->find()
            ->where([
                'tests_id' => $id
                ])
            ->toArray();

        $selectedUsers = $testHasUserTable->find()
            ->where([
                'tests_id' => $id
            ])
            ->toArray();

        $users = $usersTable
            ->find('list', [ 'keyField' => 'id',
                'valueField' => function ($e) {
                    return $e->get('firstname'). ' ' . $e->get('lastname');
                }])
            ->where([
                'role' => 'student'
            ])
            ->orderAsc('firstname')
            ->toArray();

        $groups = $groupsTable->find('list', [ 'keyField' => 'id', 'valueField' => 'group_name'])->orderAsc('group_name')->toArray();

        $test = $this->Tests->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            if (!empty($this->request->getData('group_id'))) {
                foreach ($this->request->getData('group_id') as $groupsId) {
                    if (array_search($groupsId, $selectedGroups) == false) {
                        $newTestGroup = $testHasGroupsTable->newEmptyEntity();
                        $data = ['groups_id' => (int) $groupsId, 'tests_id' => $id];
                        $newTestHasGroups = $testHasGroupsTable->patchEntity($newTestGroup, $data);
                        $testHasGroupsTable->save($newTestHasGroups);
                        continue;
                    }
                }
                foreach (array_column($selectedGroups, 'groups_id') as $groupId) {
                    if (in_array($groupId, $this->request->getData('group_id')) == false) {
                        $removedGroup = $testHasGroupsTable->find()
                            ->where([
                                'tests_id' => $id,
                                'groups_id' => $groupId
                            ])
                            ->first();

                        $testHasGroupsTable->delete($removedGroup);
                        continue;
                    }
                }
            }else{
                $removedGroups = $testHasGroupsTable->find()
                    ->where([
                        'tests_id' => $id,
                    ]);
                $testHasGroupsTable->deleteMany($removedGroups);
            }

            if (!empty($this->request->getData('user_id'))) {
                foreach ($this->request->getData('user_id') as $usersId) {
                    if (array_search($usersId, $selectedUsers) == false) {
                        $newTestUser = $testHasUserTable->newEmptyEntity();
                        $data = ['users_id' => (int) $usersId, 'tests_id' => $id];
                        $newTestHasUser = $testHasUserTable->patchEntity($newTestUser, $data);
                        $testHasUserTable->save($newTestHasUser);
                        continue;
                    }
                }
                foreach (array_column($selectedUsers, 'users_id') as $userId) {
                    if (in_array($userId, $this->request->getData('user_id')) == false) {
                        $removedUser = $testHasUserTable->find()
                            ->where([
                                'tests_id' => $id,
                                'users_id' => $usersId
                            ])
                            ->first();
                        $testHasUserTable->delete($removedUser);
                        continue;
                    }
                }
            }else{
                $removedUsers = $testHasUserTable->find()
                    ->where([
                        'tests_id' => $id,
                    ]);
                $testHasUserTable->deleteMany($removedUsers);
            }


            $test = $this->Tests->patchEntity($test, $this->request->getData());
            if ($this->Tests->save($test)) {
                $this->Flash->success(__('The test has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The test could not be saved. Please, try again.'));
        }

        $this->set(compact('test'));
        $this->set(compact('groups'));
        $this->set(compact('users'));
        $this->set(compact('selectedGroups'));
        $this->set(compact('selectedUsers'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Test id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $session = $this->getRequest()->getSession();
        if ($session->read('Auth.role') == 'student'){
            $this->Flash->error('You are not allowed here.');
            $this->redirect($this->referer('/tests'));
        }

        $this->request->allowMethod(['post', 'delete']);
        $test = $this->Tests->get($id);
        if ($this->Tests->delete($test)) {
            $this->Flash->success(__('The test has been deleted.'));
        } else {
            $this->Flash->error(__('The test could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
