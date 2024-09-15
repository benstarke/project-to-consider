<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Log $log
 */
?>
<div class="row">
    <div class="column column-80">
        <div class="logs view content">
            <h3><?= h($log->id) ?></h3>
            <table class="vertical-table logs-table">
                <tr>
                    <th><?= __('Message') ?></th>
                    <td><?= h($log->message) ?></td>
                </tr>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $log->hasValue('user') ? $this->Html->link($log->user->f_name, ['controller' => 'Users', 'action' => 'view', $log->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Action') ?></th>
                    <td><?= h($log->action) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($log->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Createtime') ?></th>
                    <td><?= h($log->createtime) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
