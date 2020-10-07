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
            $tests = $this->paginate($this->Tests);
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

        $testHasGroupsTable = TableRegistry::getTableLocator()->get('testHasGroup');
        $testHasGroups = $testHasGroupsTable->find()->toArray();

        $test = $this->Tests->newEmptyEntity();
        if ($this->request->is('post')) {
            $test = $this->Tests->patchEntity($test, $this->request->getData());
            if ($this->Tests->save($test)) {
                $this->Flash->success(__('The test has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The test could not be saved. Please, try again.'));
        }
        $this->set(compact('users'));
        $this->set(compact('test'));
        $this->set(compact('groups'));
        $this->set(compact('testHasGroups'));
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
