<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Group $group
 * @var \App\Model\Entity\User $user
 */
?>

    <div class="row">
        <aside class="column">
            <div class="side-nav">
                <h4 class="heading"><?= __('Actions') ?></h4>
                <?= $this->Html->link(__('List Groups'), ['controller' => 'groups', 'action' => 'index'], ['class' => 'side-nav-item']) ?>
            </div>
        </aside>
        <div class="column-responsive column-80">
            <div class="groups form content">
                <?= $this->Form->create($group) ?>
                <fieldset>
                    <legend><?= __('Edit Group') ?></legend>
                    <?php
                    echo $this->Form->control('group_name', ['label' => 'Group name', 'required' => true]);

                    $selectedUsers = array_column($groupsHasUsers, 'users_id');
                    debug($selectedUsers);

                    $users = array_column($users, 'id');
                    debug($users);

//                    foreach ($users as $user) {
//                        echo $this->Form->control('user_id', array(
//                            'label' => $user['firstname'] . ' ' . $user['lastname'],
//                            'value' => $user['id'],
//                            'multiple' => 'checkbox',
//                            'type' => 'checkbox',
//                            'options' => $user,
//                            'selected' => $groupsHasUsers
//                        ));
//                    }

//                    echo $this->Form->control('user_id', array(
////                        'label' => $usersNames,
//                        'value' => $users,
//                        'multiple' => 'checkbox',
//                        'type' => 'select',
//                        'options' => $users,
//                        'selected' => $selectedUsers
//                    ));

                    echo $this->Form->select('user_id', $users, [
                        'multiple' => 'checkbox',
                        'selected' => $groupsHasUsers
                    ]);

                    ?>

                </fieldset>
                <?= $this->Form->button(__('Submit')) ?>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
<?php
