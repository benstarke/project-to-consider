<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Task $task
 */
?>
<style>
table td {
    max-width: 
    white-space: normal; 
    text-overflow: ellipsis; 
    word-wrap: break-word; 
    overflow: hidden; 
    vertical-align: top; 
}
</style>

<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Task'), ['action' => 'edit', $task->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Task'), ['action' => 'delete', $task->id], ['confirm' => __('Are you sure you want to delete # {0}?', $task->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Tasks'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Task'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="tasks view content">
            <h3><?= h($task->description) ?></h3>
            <table>
                <tr>
                    <th><?= __('Description') ?></th>
                    <td class="expandable-cell"><?= h($task->description) ?></td> 
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($task->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Shift') ?></th>
                    <td><?= $task->hasValue('shift') ? $this->Html->link($task->shift->image, ['controller' => 'Shifts', 'action' => 'view', $task->shift->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($task->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Deadline') ?></th>
                    <td><?= h($task->deadline) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.expandable-cell').forEach(function(cell) {
        cell.addEventListener('click', function() {
            this.classList.toggle('expanded-cell');
            if (this.classList.contains('expanded-cell')) {
                this.style.overflow = 'visible';
                this.style.whiteSpace = 'normal';
            } else {
                this.style.overflow = 'hidden';
                this.style.whiteSpace = 'nowrap';
            }
        });
    });
});
</script>

