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
            <?= $this->Html->link(__('List Tests'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="tests form content">
            <?= $this->Form->create($test) ?>
            <fieldset>
                <legend><?= __('Add Test') ?></legend>
                <?php
                echo $this->Form->control('name');
                echo $this->Form->control('subject');
                echo $this->Form->control('date');
                echo $this->Form->control('start_time');
                echo $this->Form->control('end_time');

                $selectedGroups = array();
                foreach ($testHasGroups as $testHasGroup) {
                    $selectedGroups[] = $testHasGroup['groups_id'];
                }

                echo '<label for="group_id">Groups</label>';
                echo '<div class="container checkbox-list-box">';
                echo $this->Form->select('group_id', $groups, [
                    'multiple' => 'checkbox',
                    'default' => $selectedGroups
                ]);
                echo '</div>';

                echo '<label for="users_id">Students</label>';
                echo '<div class="container checkbox-list-box">';
                echo $this->Form->control('user_id', array(
                    'label' => false,
                    'type' => 'select',
                    'multiple' => 'checkbox',
                    'options' => $users,
                ));
                echo '</div>';

                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
