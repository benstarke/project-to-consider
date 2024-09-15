<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Shift> $shifts
 */
?>
<div class="shifts index content">
    <?= $this->Html->link(__('New Shift'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Shifts') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('start_time') ?></th>
                    <th><?= $this->Paginator->sort('end_time') ?></th>
                    <th><?= $this->Paginator->sort('image') ?></th>
                    <th><?= $this->Paginator->sort('isLeaves') ?></th>
                    <th><?= $this->Paginator->sort('roster_id') ?></th>
                    <th><?= $this->Paginator->sort('role_id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($shifts as $shift): ?>
                <tr>
                    <td><?= $this->Number->format($shift->id) ?></td>
                    <td><?= h($shift->start_time) ?></td>
                    <td><?= h($shift->end_time) ?></td>
                    <td><?= h($shift->image) ?></td>
                    <td><?= h($shift->isLeaves) ?></td>
                    <td><?= $shift->hasValue('roster') ? $this->Html->link($shift->roster->id, ['controller' => 'Rosters', 'action' => 'view', $shift->roster->id]) : '' ?></td>
                    <td><?= $shift->hasValue('role') ? $this->Html->link($shift->role->name, ['controller' => 'Roles', 'action' => 'view', $shift->role->id]) : '' ?></td>
                    <td><?= $shift->hasValue('user') ? $this->Html->link($shift->user->firstName, ['controller' => 'Users', 'action' => 'view', $shift->user->id]) : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $shift->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $shift->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $shift->id], ['confirm' => __('Are you sure you want to delete # {0}?', $shift->id)]) ?>
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
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
