<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LeaveRequest $leaveRequest
 * @var string[]|\Cake\Collection\CollectionInterface $users
 */
$this->Html->css('https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css', ['block' => true]);
$this->Html->script('https://cdn.jsdelivr.net/npm/flatpickr', ['block' => true]);
?>

<main>
    <div class="container-fluid px-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= $this->Url->buildFromPath('Pages::index') ?>" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= $this->Url->buildFromPath('LeaveRequests::index') ?>" class="text-decoration-none">Leave Requests</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Leave Request</li>
            </ol>
        </nav>

        <h1 class="mt-4">Edit Leave Request</h1>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-edit me-1"></i>
                Edit Leave Request Details
            </div>
            <div class="card-body">
                <?= $this->Form->create($leaveRequest, ['class' => 'needs-validation', 'novalidate']) ?>
                <div class="row g-3">
                    <div class="col-md-6">
                        <?= $this->Form->control('user_id', [
                            'options' => $users,
                            'class' => 'form-select',
                            'label' => ['class' => 'form-label'],
                            'empty' => 'Select Employee',
                            'required'
                        ]) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $this->Form->control('leave_type', [
                            'options' => [
                                'vacation' => 'Vacation',
                                'sick' => 'Sick Leave',
                                'personal' => 'Personal Leave'
                            ],
                            'class' => 'form-select',
                            'label' => ['class' => 'form-label'],
                            'empty' => 'Select Leave Type',
                            'required'
                        ]) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $this->Form->control('start_date', [
                            'type' => 'text',
                            'class' => 'form-control datepicker',
                            'label' => ['class' => 'form-label'],
                            'required'
                        ]) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $this->Form->control('end_date', [
                            'type' => 'text',
                            'class' => 'form-control datepicker',
                            'label' => ['class' => 'form-label'],
                            'required'
                        ]) ?>
                    </div>
                    <div class="col-12">
                        <?= $this->Form->control('reason', [
                            'type' => 'textarea',
                            'class' => 'form-control',
                            'label' => ['class' => 'form-label'],
                            'required'
                        ]) ?>
                    </div>
                    <?php if ($this->Identity->get('isManager') || $this->Identity->get('isAdmin')): ?>
                        <div class="col-md-6">
                            <?= $this->Form->control('status', [
                                'options' => [
                                    'pending' => 'Pending',
                                    'approved' => 'Approved',
                                    'denied' => 'Denied'
                                ],
                                'class' => 'form-select',
                                'label' => ['class' => 'form-label'],
                                'empty' => 'Select Status'
                            ]) ?>
                        </div>
                        <div class="col-12">
                            <?= $this->Form->control('manager_comments', [
                                'type' => 'textarea',
                                'class' => 'form-control',
                                'label' => ['class' => 'form-label']
                            ]) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="mt-4">
                    <?= $this->Form->button(__('Update Leave Request'), ['class' => 'btn btn-primary']) ?>
                    <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>

        <?php if ($this->Identity->get('isManager') || $this->Identity->get('isAdmin')): ?>
            <div class="card bg-danger text-white mb-4">
                <div class="card-header">
                    <i class="fas fa-exclamation-triangle me-1"></i>
                    Danger Zone
                </div>
                <div class="card-body">
                    <p class="card-text">Deleting a leave request cannot be undone. Please be certain.</p>
                    <?= $this->Form->postLink(
                        __('Delete Leave Request'),
                        ['action' => 'delete', $leaveRequest->id],
                        ['confirm' => __('Are you sure you want to delete this leave request?'), 'class' => 'btn btn-light']
                    ) ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php $this->start('script'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    flatpickr(".datepicker", {
        dateFormat: "Y-m-d",
    });

    // Bootstrap form validation
    (function() {
        'use strict';
        var forms = document.querySelectorAll('.needs-validation');
        Array.prototype.slice.call(forms).forEach(function(form) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();
});
</script>
<?php $this->end(); ?>