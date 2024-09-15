<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Shift $shift
 * @var string[]|\Cake\Collection\CollectionInterface $rosters
 * @var string[]|\Cake\Collection\CollectionInterface $roles
 * @var string[]|\Cake\Collection\CollectionInterface $users
 */
?>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />

<div class="rosters index content">
    <div class="">
        <nav class="bg-light d-flex justify-content-between align-items-center">
            <div class="ml-5 mr-3">
                <h3 class='text-primary'><?= __('Roster & Shift Management') ?></h3>
                <ol class="breadcrumb" style="margin: 0;">
                    <li class="breadcrumb-item text-decoration-none"><a href="<?= $this->Url->buildFromPath('Pages::index') ?>" class='text-decoration-none text-info'>Dashboard</a></li>
                    <?= $this->Html->link(__('Rosters'), ['action' => 'index'], ['class' => 'breadcrumb-item active text-decoration-none']) ?>
                </ol>
            </div>
            <div>
                <a href="<?= $this->Url->build(['controller' => 'Rosters', 'action' => 'index']) ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                    <i class="fas fa-list fa-sm text-white-50"></i> View All Rosters </a>
            </div>
        </nav>
    </div>
</div>
<br>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title"><?= __('Edit Shift')?></h4>
                        <div class="button-group">
                            <a href="#" onclick="history.go(-1);" class="btn btn-sm btn-primary shadow-sm">
                                <i class="fas fa-sm text-white-50"></i> Back
                            </a>
                            <?= $this->Form->postLink(__('Delete'), ['controller' => 'Shifts', 'action' => 'delete', $shift->id], [
                                'confirm' => __('Are you sure you want to delete this shift?'),
                                'class' => 'btn btn-danger btn-sm']) ?>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <?= $this->Form->create($shift) ?>
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="form-group">
                                <?= $this->Form->control('start_time', ['type' => 'time', 'class' => 'form-control','label' => ['text' => 'Start Time'], 'style' => 'width: 100%', 'step' => 60, 'value' => date('h:i A', strtotime($shift->start_time))]) ?>
                            </div>
                            <div class="form-group">
                                <?= $this->Form->control('end_time', ['type' => 'time', 'class' => 'form-control','label' => ['text' => 'End Time'], 'style' => 'width: 100%', 'step' => 60, 'value' => date('h:i A', strtotime($shift->end_time))]) ?>
                            </div>
                            <div class="form-group">
                                <?= $this->Form->control('role_id', ['class' => 'form-control', 'label' => ['text' => 'Role'], 'style' => 'width: 100%']) ?>
                            </div>
                            <div class="form-group">
                                <?php
                                $options = [];
                                foreach ($users as $user) {
                                    $options[$user->id] =ucfirst($user->f_name) . ' ' . ucfirst($user->l_name)
                                    ;
                                }
                                echo $this->Form->control('user_id', ['options' => $options, 'class' => 'form-control', 'label' => ['text' => 'Employee'], 'style' => 'width: 100%;']);
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <?= $this->Form->button(__('Update'), ['class' => 'btn btn-success btn-block']) ?>
                        </div>
                    </div>
                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
    </div>
</div>



