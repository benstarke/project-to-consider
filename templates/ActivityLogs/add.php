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
            <?= $this->Html->link(__('List Activity Logs'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="activityLogs form content">
            <?= $this->Form->create($activityLog) ?>
            <fieldset>
                <legend><?= __('Add Activity Log') ?></legend>
                <?php
                    echo $this->Form->control('created_at');
                    echo $this->Form->control('scope_model');
                    echo $this->Form->control('scope_id');
                    echo $this->Form->control('issuer_model');
                    echo $this->Form->control('issuer_id');
                    echo $this->Form->control('object_model');
                    echo $this->Form->control('object_id');
                    echo $this->Form->control('level');
                    echo $this->Form->control('action');
                    echo $this->Form->control('message');
                    echo $this->Form->control('data');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
