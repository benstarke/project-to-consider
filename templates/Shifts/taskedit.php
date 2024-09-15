<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Task $task
 * @var string[]|\Cake\Collection\CollectionInterface $shifts
 */
?>

<main>
    <div class="d-flex justify-content-between align-items-center bg-light p-3">
        <div>
            <h3 class="text-dark"><?= __('Tasks') ?></h3>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= $this->Url->buildFromPath('Pages::index') ?>" class="text-decoration-none text-dark">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= $this->Url->build(['action' => 'index']) ?>" class="text-decoration-none text-dark">Tasks</a></li>
                <li class="breadcrumb-item active text-muted"><?= __('Edit') ?></li>
            </ol>
        </div>
    </div>

    <div class="row justify-content-center mt-4">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><?= __('Edit Tasks') ?></h5>
                    <div>
                        <?= $this->Html->link('<i class="fa fa-arrow-left"></i> ' . __('Back'), ['action' => 'index'], ['class' => 'btn btn-secondary btn-sm', 'escape' => false]) ?>
                    </div>
                </div>
                <div class="card-body">
                <?= $this->Form->create($task) ?>
                    <fieldset>
                   
                        <?php
                            echo $this->Form->control('id', [
                                'label' => 'id',
                                'class' => 'form-control',
                                'rows' => 5
                            ]);
                        
                            echo $this->Form->control('description', [
                                'label' => 'Task Description',
                                'class' => 'form-control',
                                'rows' => 5,
                                'style' => 'color: ' . h($task->description_color)
                            ]);

                            echo $this->Form->control('description_color', [
                                'type' => 'select',
                                'options' => [
                                    'green' => 'Normal Task (Green)',
                                    'red' => 'Critical Task (Red)'
                                ],
                                'label' => 'Task type',
                                'class' => 'form-control',
                                'value' => $task->description_color 
                            ]);

                            echo $this->Form->control('status', [
                                'type' => 'select',
                                'options' => [
                                    'Pending' => 'Pending',
                                    'In Process' => 'In Process',
                                    'Completed' => 'Completed'
                                ],
                                'label' => 'Task Status',
                                'class' => 'form-control'
                            ]);

                            echo $this->Form->control('deadline', [
                                'type' => 'datetime',
                                'label' => 'Deadline',
                                'class' => 'form-control'
                            ]);

                            echo $this->Form->control('responsibility', [
                                'label' => 'Responsibility',
                                'class' => 'form-control',
                                'type' => 'textarea',
                                'rows' => 5
                            ]);

                        ?>
                    </fieldset>
                    <div class="text-center mt-4">
                        <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>
                    </div>
                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
    </div>
</main>

