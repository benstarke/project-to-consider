<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Availability> $availabilities
 */
?>
<div class="availabilities index content">
    <?= $this->Html->link(__('New Availability'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Availabilities') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('monday') ?></th>
                    <th><?= $this->Paginator->sort('tuesday') ?></th>
                    <th><?= $this->Paginator->sort('wednesday') ?></th>
                    <th><?= $this->Paginator->sort('thursday') ?></th>
                    <th><?= $this->Paginator->sort('friday') ?></th>
                    <th><?= $this->Paginator->sort('saturday') ?></th>
                    <th><?= $this->Paginator->sort('sunday') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($availabilities as $availability): ?>
                <tr>
                    <td><?= $this->Number->format($availability->id) ?></td>
                    <td><?= $availability->hasValue('user') ? $this->Html->link($availability->user->f_name . ' ' . $availability->user->l_name, ['controller' => 'Users', 'action' => 'view', $availability->user->id]) : '' ?></td>
                    <td><?= h($availability->monday) ?></td>
                    <td><?= h($availability->tuesday) ?></td>
                    <td><?= h($availability->wednesday) ?></td>
                    <td><?= h($availability->thursday) ?></td>
                    <td><?= h($availability->friday) ?></td>
                    <td><?= h($availability->saturday) ?></td>
                    <td><?= h($availability->sunday) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $availability->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $availability->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $availability->id], ['confirm' => __('Are you sure you want to delete # {0}?', $availability->id)]) ?>
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
