<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ActivityLog $activityLog
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Activity Log'), ['action' => 'edit', $activityLog->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Activity Log'), ['action' => 'delete', $activityLog->id], ['confirm' => __('Are you sure you want to delete # {0}?', $activityLog->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Activity Logs'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Activity Log'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="activityLogs view content">
            <h3><?= h($activityLog->scope_model) ?></h3>
            <table>
                <tr>
                    <th><?= __('Scope Model') ?></th>
                    <td><?= h($activityLog->scope_model) ?></td>
                </tr>
                <tr>
                    <th><?= __('Scope Id') ?></th>
                    <td><?= h($activityLog->scope_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Issuer Model') ?></th>
                    <td><?= h($activityLog->issuer_model) ?></td>
                </tr>
                <tr>
                    <th><?= __('Issuer Id') ?></th>
                    <td><?= h($activityLog->issuer_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Object Model') ?></th>
                    <td><?= h($activityLog->object_model) ?></td>
                </tr>
                <tr>
                    <th><?= __('Object Id') ?></th>
                    <td><?= h($activityLog->object_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Level') ?></th>
                    <td><?= h($activityLog->level) ?></td>
                </tr>
                <tr>
                    <th><?= __('Action') ?></th>
                    <td><?= h($activityLog->action) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($activityLog->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created At') ?></th>
                    <td><?= h($activityLog->created_at) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Message') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($activityLog->message)); ?>
                </blockquote>
            </div>
            <div class="text">
                <strong><?= __('Data') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($activityLog->data)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
