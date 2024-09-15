<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\ActivityLog> $activityLogs
 */
?>
<div class="activityLogs index content">
    <?= $this->Html->link(__('New Activity Log'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Activity Logs') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('created_at') ?></th>
                    <th><?= $this->Paginator->sort('scope_model') ?></th>
                    <th><?= $this->Paginator->sort('scope_id') ?></th>
                    <th><?= $this->Paginator->sort('issuer_model') ?></th>
                    <th><?= $this->Paginator->sort('issuer_id') ?></th>
                    <th><?= $this->Paginator->sort('object_model') ?></th>
                    <th><?= $this->Paginator->sort('object_id') ?></th>
                    <th><?= $this->Paginator->sort('level') ?></th>
                    <th><?= $this->Paginator->sort('action') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($activityLogs as $activityLog): ?>
                <tr>
                    <td><?= $this->Number->format($activityLog->id) ?></td>
                    <td><?= h($activityLog->created_at) ?></td>
                    <td><?= h($activityLog->scope_model) ?></td>
                    <td><?= h($activityLog->scope_id) ?></td>
                    <td><?= h($activityLog->issuer_model) ?></td>
                    <td><?= h($activityLog->issuer_id) ?></td>
                    <td><?= h($activityLog->object_model) ?></td>
                    <td><?= h($activityLog->object_id) ?></td>
                    <td><?= h($activityLog->level) ?></td>
                    <td><?= h($activityLog->action) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $activityLog->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $activityLog->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $activityLog->id], ['confirm' => __('Are you sure you want to delete # {0}?', $activityLog->id)]) ?>
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
