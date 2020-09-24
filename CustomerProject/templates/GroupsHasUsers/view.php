<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\GroupsHasUser $groupsHasUser
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
        <div class="groupsHasUsers view content">
            <h3><?= h($group->group_name) ?></h3>
            <table>
                <?php foreach($groupsHasUsers as $groupsHasUser): ?>
                <tr>
                    <th><?= __('User') ?></th>
                    <td>
                        <?= $groupsHasUser->has('user') ? $this->Html->link($groupsHasUser->user->id,
                            ['controller' => 'Users', 'action' => 'view', $groupsHasUser->user->id]) : '' ?>
                    </td>
                    <td>
                        <?= $this->Html->link($groupsHasUser->user->firstname. '' . $groupsHasUser->user->lastname, ['controller' => 'Users', 'action' => 'view', $groupsHasUser->user->id]); ?>
                    </td>
                </tr>
                <?php endforeach ?>
            </table>
        </div>
    </div>
</div>
