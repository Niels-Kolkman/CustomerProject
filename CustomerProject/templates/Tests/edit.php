<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Test $test
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $test->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $test->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Tests'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="tests form content">
            <?= $this->Form->create($test) ?>
            <fieldset>
                <legend><?= __('Edit Test') ?></legend>
                <?php
                    echo $this->Form->control('name');
                    echo $this->Form->control('subject');
                    echo $this->Form->control('date');
                    echo $this->Form->control('start_time');
                    echo $this->Form->control('end_time');

                echo '<div class="container checkbox-list-box">';
                echo '<label for="group_id">Groups</label>';
                echo $this->Form->select('group_id', $groups, [
                    'multiple' => 'checkbox',
                    'default' => array_column($selectedGroups, 'groups_id')
                ]);
                echo '</div>';

                echo '<div class="container checkbox-list-box">';
                echo '<label for="users_id">Students</label>';
                echo $this->Form->select('user_id', $users ,[
                    'multiple' => 'checkbox',
                    'default' => array_column($selectedUsers, 'users_id')
                ]);
                echo '</div>';
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
