<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Operation $operation
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Operation'), ['action' => 'edit', $operation->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Operation'), ['action' => 'delete', $operation->id], ['confirm' => __('Are you sure you want to delete # {0}?', $operation->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Operations'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Operation'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="operations view content">
            <h3><?= h($operation->day_name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Day Name') ?></th>
                    <td><?= h($operation->day_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($operation->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Day Start') ?></th>
                    <td><?= h($operation->day_start) ?></td>
                </tr>
                <tr>
                    <th><?= __('Day End') ?></th>
                    <td><?= h($operation->day_end) ?></td>
                </tr>
                <tr>
                    <th><?= __('IsActive') ?></th>
                    <td><?= $operation->isActive ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
