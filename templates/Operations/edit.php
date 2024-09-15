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
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $operation->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $operation->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Operations'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="operations form content">
            <?= $this->Form->create($operation) ?>
            <fieldset>
                <legend><?= __('Edit Operation') ?></legend>
                <?php
                    echo $this->Form->control('day_name');
                    echo $this->Form->control('day_start', ['empty' => true]);
                    echo $this->Form->control('day_end', ['empty' => true]);
                    echo $this->Form->control('isActive');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
