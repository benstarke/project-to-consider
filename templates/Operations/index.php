<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Operation> $operations
 */
?>
<div class="operations index content">
    <?= $this->Html->link(__('New Operation'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Operations') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('day_name') ?></th>
                    <th><?= $this->Paginator->sort('day_start') ?></th>
                    <th><?= $this->Paginator->sort('day_end') ?></th>
                    <th><?= $this->Paginator->sort('isActive') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($operations as $operation): ?>
                <tr>
                    <td><?= $this->Number->format($operation->id) ?></td>
                    <td><?= h($operation->day_name) ?></td>
                    <td><?= h($operation->day_start) ?></td>
                    <td><?= h($operation->day_end) ?></td>
                    <td><?= h($operation->isActive) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $operation->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $operation->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $operation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $operation->id)]) ?>
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
