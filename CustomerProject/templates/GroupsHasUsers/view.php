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
            <h3>Group: <?= h($group->group_name) ?></h3>
            <table>
                <?php foreach($users as $user): ?>
                <tr>
                    <th><?= __('Student') ?></th>
                    <td>
                        <?= $this->Html->link($user['firstname'] . ' ' . $user['lastname'], ['controller' => 'Users', 'action' => 'view', $user->id]); ?>
                    </td>
                </tr>
                <?php endforeach ?>
            </table>
        </div>
    </div>
</div>
