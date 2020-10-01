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
                   // debug($group); die();
                    echo $this->Form->control('group_name', ['label' => 'Group name', 'required' => true, 'default' => $group->name]);
                    $selectedUsers = array();
                    foreach($groupsHasUsers as $groupsHasUser){
                        $selectedUsers[] = $groupsHasUser['users_id'];
                    }
                    echo $this->Form->select('user_id', $users, [
                        'multiple' => 'checkbox',
                        'default' => $selectedUsers
                    ]);
                    ?>
                </fieldset>
                <?= $this->Form->button(__('Submit')) ?>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
<?php
