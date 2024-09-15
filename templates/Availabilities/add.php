<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Availability $availability
 * @var \Cake\Collection\CollectionInterface|string[] $users
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Availabilities'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="availabilities form content">
            <?= $this->Form->create($availability) ?>
            <fieldset>
                <legend><?= __('Add Availability') ?></legend>
                <?php
                    echo $this->Form->control('user_id', ['options' => $users]);
                    echo $this->Form->control('monday');
                    echo $this->Form->control('tuesday');
                    echo $this->Form->control('wednesday');
                    echo $this->Form->control('thursday');
                    echo $this->Form->control('friday');
                    echo $this->Form->control('saturday');
                    echo $this->Form->control('sunday');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
