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
        $tests = $this->paginate($this->Tests);

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

        $this->set(compact('test'));
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
            ])->toArray();

        $groupsTable = TableRegistry::getTableLocator()->get('groups');
        $groups = $groupsTable->find('list', [ 'keyField' => 'id', 'valueField' => 'group_name'])->toArray();

        $test = $this->Tests->newEmptyEntity();
        $allTests = $this->Tests->find()->toArray();

        if ($this->request->is('post')) {
            $test = $this->Tests->patchEntity($test, $this->request->getData());
            if (array_search($this->request->getData('name'), $allTests) !==  false) {
                if ($this->Tests->save($test)) {
                    $this->Flash->success(__('The test has been saved.'));
                } else {
                    $this->Flash->error(__('The test could not be saved. Please, try again.'));
                    return $this->redirect(['action' => 'index']);
                }


                $newTestId = $this->Tests->find()
                    ->where([
                        'name' => $this->request->getData('name'),
                    ])
                    ->select('id')
                    ->first();


                if (!empty($this->request->getData('group_id'))) {
                    $testHasGroupsTable = TableRegistry::getTableLocator()->get('testHasGroup');
                    $groups = $this->request->getData('group_id');
                    foreach ($groups as $group) {
                        $testHasGroups = $testHasGroupsTable->newEmptyEntity();
                        $data = ['groups_id' => $group->id, 'tests_id' => $newTestId['id']];
                        $newTestHasGroups = $testHasGroupsTable->patchEntity($testHasGroups, $data);
                        $testHasGroupsTable->save($newTestHasGroups);
                    }
                }
                if (!empty($this->request->getData('user_id'))) {
                    $testHasUserTable = TableRegistry::getTableLocator()->get('testHasUser');
                    $students = $this->request->getData('user_id');
                    foreach ($students as $student) {
                        $testHasUser = $testHasUserTable->newEmptyEntity();
                        $data = ['users_id' => $student->id, 'tests_id' => $newTestId['id']];
                        $newTestHasUsers = $testHasUserTable->patchEntity($testHasUser, $data);
                        $testHasUserTable->save($newTestHasUsers);
                    }
                }
                return $this->redirect(['action' => 'index']);
            }else{
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
        $session = $this->getRequest()->getSession();
        if ($session->read('Auth.role') == 'student'){
            $this->Flash->error('You are not allowed here.');
            $this->redirect($this->referer('/tests'));
        }

        $test = $this->Tests->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $test = $this->Tests->patchEntity($test, $this->request->getData());
            if ($this->Tests->save($test)) {
                $this->Flash->success(__('The test has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The test could not be saved. Please, try again.'));
        }
        $this->set(compact('test'));
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
