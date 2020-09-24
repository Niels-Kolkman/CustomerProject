<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;

/**
 * GroupsHasUsers Controller
 *
 * @property \App\Model\Table\GroupsHasUsersTable $GroupsHasUsers
 * @method \App\Model\Entity\GroupsHasUser[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class GroupsHasUsersController extends AppController
{

    /**
     * View method
     *
     * @param string|null $id Groups Has User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $usersTable = TableRegistry::getTableLocator()->get('Users');
        $groupsTable = TableRegistry::getTableLocator()->get('Groups');
        $this->set('usersTable', $usersTable);
        $this->set('group', $groupsTable->get($id));
        $groupsHasUsers =
            $this->GroupsHasUsers
                ->find()
                ->where([
                    'groups_id' => $id
                ])
                ->toArray();
        $this->set('groupsHasUsers', $groupsHasUsers);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $usersTable = TableRegistry::getTableLocator()->get('Users');
        $groupsTable = TableRegistry::getTableLocator()->get('Groups');
        $groups = $this->GroupsHasUsers->Groups->newEmptyEntity();

        if ($this->request->is('post')) {
            $groups = $this->GroupsHasUsers->Groups->patchEntity($groups, $this->request->getData());
            if ($this->GroupsHasUsers->Groups->save($groups)) {
                $this->Flash->success(__('The group has been saved.'));

                $groupId = $groupsTable->find()->where(['group_name' => $groups['group_name']])->first();
                $groupUsers = $this->request->getData('user_id');
             foreach($groupUsers as $id) {
                 $groupsHasUsers = $this->GroupsHasUsers->newEmptyEntity();
                $data = [
                    'groups_id' => $groupId['id'],
                    'users_id' => $id
                ];
                 $a = $this->GroupsHasUsers->patchEntity($groupsHasUsers, $data);
                 $this->GroupsHasUsers->save($a);
             }
                return $this->redirect(['controller' => 'Groups', 'action' => 'index']);
            }
            $this->Flash->error(__('The group could not be saved. Please, try again.'));
        }
        $users = $usersTable
            ->find('list', [ 'keyField' => 'id',
                'valueField' => function ($e) {
                    return $e->get('firstname'). ' ' . $e->get('lastname');
                }])
            ->where([
                'role' => 'student'
            ])->toArray();

        $this->set('group', $groups);
        $this->set(compact('users') );
    }

    /**
     * Edit method
     *
     * @param string|null $id Groups Has User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $groupsHasUser = $this->GroupsHasUsers->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $groupsHasUser = $this->GroupsHasUsers->patchEntity($groupsHasUser, $this->request->getData());
            if ($this->GroupsHasUsers->save($groupsHasUser)) {
                $this->Flash->success(__('The groups has user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The groups has user could not be saved. Please, try again.'));
        }
        $groups = $this->GroupsHasUsers->Groups->find('list', ['limit' => 200]);
        $users = $this->GroupsHasUsers->Users->find('list', ['limit' => 200]);
        $this->set(compact('groupsHasUser', 'groups', 'users'));
    }

}
