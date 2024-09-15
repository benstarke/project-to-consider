<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LeaveRequest $leaveRequest
 */
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary"><?= __('Review Leave Request') ?></h6>
                    <?= $this->Html->link(__('Back to List'), ['action' => 'index'], ['class' => 'btn btn-secondary btn-sm']) ?>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5><?= __('Employee') ?>: <?= h($leaveRequest->user->full_name) ?></h5>
                            <p><strong><?= __('Leave Type') ?>:</strong> <?= h($leaveRequest->leave_type) ?></p>
                            <p><strong><?= __('Start Date') ?>:</strong> <?= h($leaveRequest->start_date->format('Y-m-d')) ?></p>
                            <p><strong><?= __('End Date') ?>:</strong> <?= h($leaveRequest->end_date->format('Y-m-d')) ?></p>
                        </div>
                        <div class="col-md-6">
                            <h5><?= __('Reason for Leave') ?></h5>
                            <p><?= h($leaveRequest->reason) ?></p>
                        </div>
                    </div>

                    <?= $this->Form->create($leaveRequest, ['class' => 'needs-validation', 'novalidate']) ?>
                    <?= $this->Form->control('status', ['type' => 'hidden', 'value' => 'approved']) ?>
                    <div class="form-group">
                        <?= $this->Form->control('manager_comments', [
                            'type' => 'textarea',
                            'class' => 'form-control',
                            'label' => ['class' => 'form-label', 'text' => __('Manager Comments')],
                            'placeholder' => __('Enter your comments here...'),
                            'required'
                        ]) ?>
                    </div>
                    <div class="form-group">
                        <?= $this->Form->button(__('Approve Request'), ['class' => 'btn btn-success mr-2']) ?>
                        <?= $this->Html->link(__('Deny Request'), 
                            ['action' => 'deny', $leaveRequest->id],
                            ['class' => 'btn btn-danger', 'confirm' => __('Are you sure you want to deny this leave request?')]
                        ) ?>
                    </div>
                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->start('script'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Bootstrap form validation
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
});
</script>
<?php $this->end(); ?>