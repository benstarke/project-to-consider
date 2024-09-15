<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Shift $shift
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Shift'), ['action' => 'edit', $shift->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Shift'), ['action' => 'delete', $shift->id], ['confirm' => __('Are you sure you want to delete {0}?', $shift->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Shifts'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Shift'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="shifts view content">
            <h3><?= h($shift->image) ?></h3>
            <table>
                <tr>
                    <th><?= __('Image') ?></th>
                    <td><?= h($shift->image) ?></td>
                </tr>
                <tr>
                    <th><?= __('Roster') ?></th>
                    <td><?= $shift->hasValue('roster') ? $this->Html->link($shift->roster->id, ['controller' => 'Rosters', 'action' => 'view', $shift->roster->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Role') ?></th>
                    <td><?= $shift->hasValue('role') ? $this->Html->link($shift->role->name, ['controller' => 'Roles', 'action' => 'view', $shift->role->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $shift->hasValue('user') ? $this->Html->link($shift->user->firstName, ['controller' => 'Users', 'action' => 'view', $shift->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($shift->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Start Time') ?></th>
                    <td><?= h($shift->start_time) ?></td>
                </tr>
                <tr>
                    <th><?= __('End Time') ?></th>
                    <td><?= h($shift->end_time) ?></td>
                </tr>
                <tr>
                    <th><?= __('IsLeaves') ?></th>
                    <td><?= $shift->isLeaves ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
