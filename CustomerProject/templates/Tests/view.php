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
            <?php if ($this->getRequest()->getSession()->read('Auth.role') !== 'student'): ?>
                <?= $this->Html->link(__('New Test'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
                <?= $this->Html->link(__('Edit Test'), ['action' => 'edit', $test->id], ['class' => 'side-nav-item']) ?>
                <?= $this->Form->postLink(__('Delete Test'), ['action' => 'delete', $test->id], ['confirm' => __('Are you sure you want to delete # {0}?', $test->id), 'class' => 'side-nav-item']) ?>
            <?php endif; ?>
            <?= $this->Html->link(__('List Tests'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>

        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="tests view content">
            <h3>Test: <?= h($test->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($test->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Subject') ?></th>
                    <td><?= h($test->subject) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date') ?></th>
                    <td><?= h($test->date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Start Time') ?></th>
                    <td><?= h(date("h:i A", strtotime($test->start_time))) ?></td>
                </tr>
                <tr>
                    <th><?= __('End Time') ?></th>
                    <td><?= h(date("h:i A", strtotime($test->end_time))) ?></td>
                </tr>
            </table>

            <table class="checkbox-list-box">
                <tr>
                    <th><?= __('Groups') ?></th>
                </tr>
                <?php foreach ($selectedGroups as $group): ?>
                    <tr>
                        <td><?= h($group->group->group_name) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>

            <table class="checkbox-list-box">
                <tr>
                    <th><?= __('Users') ?></th>
                </tr>
                    <?php foreach ($selectedUsers as $user): ?>
                        <tr>
                            <td><?= h($user->user->firstname . ' ' . $user->user->lastname) ?></td>
                        </tr>
                  <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>
