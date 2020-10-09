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
        $users = $this->GroupsHasUsers->find()->where(['groups_id' => $id])->toArray();
        $usersInGroup = array();
        foreach ($users as $user) {
            $usersInGroup[] = $usersTable->get($user['users_id']);
        }
        $this->set('users', $usersInGroup);
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
                if (!empty($groupUsers)) {
                    foreach ($groupUsers as $id) {
                        $groupsHasUsers = $this->GroupsHasUsers->newEmptyEntity();
                        $data = [
                            'groups_id' => $groupId['id'],
                            'users_id' => $id
                        ];
                        $a = $this->GroupsHasUsers->patchEntity($groupsHasUsers, $data);
                        $this->GroupsHasUsers->save($a);
                    }
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
            ])
            ->orderAsc('firstname')
            ->toArray();

        $this->set('group', $groups);
        $this->set(compact('users'));
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
        $usersTable = TableRegistry::getTableLocator()->get('Users');
        $groupsTable = TableRegistry::getTableLocator()->get('Groups');
        $group = $groupsTable->find()->where(['id' => $id])->first();

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

        $groupsHasUsers = $this->GroupsHasUsers->find()->where(['groups_id' => $id])->toArray();


        if ($this->request->is(['patch', 'post', 'put'])) {
            if ($this->request->getData('group_name') !== $group->group_name){
                $groupNewName = $groupsTable->patchEntity($group, $this->request->getData('group_name'));
                $groupsTable->save($groupNewName);
                $this->Flash->success(__('The group name has been saved.'));
            }
            if (empty($this->request->getData('user_id')) == false) {
                $usersAdded = false;
                foreach ($this->request->getData('user_id') as $user) {
                    if (array_search($user, array_column($groupsHasUsers, 'users_id')) == false) {
                        $newUser = $this->GroupsHasUsers->newEmptyEntity();
                        $GroupAndUserId = ['groups_id' => $id, 'users_id' => $user];

                        $newUser = $this->GroupsHasUsers->patchEntity($newUser, $GroupAndUserId);
                        if ($this->GroupsHasUsers->save($newUser)) {
                            $usersAdded = true;
                            continue;
                        }
                    }
                }
                if ($usersAdded) {
                    $this->Flash->success(__('User(s) added to group'));
                }

                $usersRemoved = false;
                foreach (array_column($groupsHasUsers, 'users_id') as $existingUser) {
                    if (in_array($existingUser, $this->request->getData('user_id')) == false) {
                        $removedUser = $this->GroupsHasUsers->find()
                            ->where([
                                'groups_id' => $id,
                                'users_id' => $existingUser
                            ])
                            ->first();
                        if ($this->GroupsHasUsers->delete($removedUser)) {
                            $usersRemoved = true;
                        }
                    }
                }
                if ($usersRemoved) {
                    $this->Flash->success(__('User(s) removed from group'));
                }
            }else{
                $removedUsers = $this->GroupsHasUsers->find()
                    ->where([
                        'groups_id' => $id
                    ])
                    ->toArray();
               $this->GroupsHasUsers->deleteMany($removedUsers);
               $this->Flash->success(__('User(s) removed from group'));
            }
        }
        $this->set('group', $group);
        $this->set('users', $users);
        $this->set('groupsHasUsers', $groupsHasUsers);
    }

}
