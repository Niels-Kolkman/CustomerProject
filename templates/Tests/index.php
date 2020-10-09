<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Test[]|\Cake\Collection\CollectionInterface $tests
 */
$date = \Cake\I18n\Time::today()->format('m-d-y');
$now = \Cake\I18n\Time::now('Europe/Amsterdam');
?>
<div class="tests index content">
    <?php if ($this->getRequest()->getSession()->read('Auth.role') !== 'student'): ?>
        <?= $this->Html->link(__('New Test'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <?php endif; ?>
    <h3><?= __('Tests') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('subject') ?></th>
                    <th><?= $this->Paginator->sort('date') ?></th>
                    <th><?= $this->Paginator->sort('start_time') ?></th>
                    <th><?= $this->Paginator->sort('end_time') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tests as $test): ?>

                <tr>
                    <td><?= h($test->name) ?></td>
                    <td><?= h($test->subject) ?></td>
                    <td><?= h($test->date) ?></td>
                    <td><?= h(date("h:i A", strtotime($test->start_time))) ?></td>
                    <td><?= h(date("h:i A", strtotime($test->end_time))) ?></td>
                    <td class="actions">
                        <?php if ($this->getRequest()->getSession()->read('Auth.role') == 'student'): ?>
                            <?php  if ($test->date->format('m-d-y') == $date): ?>
                                <?php if (strtotime($test->start_time) < strtotime($now)): ?>
                                    <?php if (strtotime($test->end_time) >  strtotime($now)):  ?>
                                        <?= $this->Html->link(__('View'), ['action' => 'view', $test->id]) ?>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php else: ?>
                            <?= $this->Html->link(__('View'), ['action' => 'view', $test->id]) ?>
                        <?php endif; ?>
                        <?php if ($this->getRequest()->getSession()->read('Auth.role') !== 'student'): ?>
                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $test->id]) ?>
                            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $test->id], ['confirm' => __('Are you sure you want to delete # {0}?', $test->id)]) ?>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
    </div>
</div>
