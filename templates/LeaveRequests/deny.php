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
                    <h6 class="m-0 font-weight-bold text-primary"><?= __('Deny Leave Request') ?></h6>
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
                    <?= $this->Form->control('status', ['type' => 'hidden', 'value' => 'denied']) ?>
                    <div class="form-group">
                        <?= $this->Form->control('manager_comments', [
                            'type' => 'textarea',
                            'class' => 'form-control',
                            'label' => ['class' => 'form-label', 'text' => __('Reason for Denial')],
                            'placeholder' => __('Please provide a reason for denying this leave request...'),
                            'required'
                        ]) ?>
                    </div>
                    <div class="form-group">
                        <?= $this->Form->button(__('Confirm Denial'), ['class' => 'btn btn-danger mr-2']) ?>
                        <?= $this->Html->link(__('Cancel'), 
                            ['action' => 'index'],
                            ['class' => 'btn btn-secondary']
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