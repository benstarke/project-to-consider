<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LeaveRequest $leaveRequest
 * @var \Cake\Collection\CollectionInterface|string[] $users
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
                <li class="breadcrumb-item active" aria-current="page">Add Leave Request</li>
            </ol>
        </nav>

        <h1 class="mt-4">Add Leave Request</h1>

        <div class="card mb-4">
            <div class="card-body">
                <?= $this->Form->create($leaveRequest, ['class' => 'needs-validation', 'novalidate']) ?>
                <div class="row g-3">
                    <?php if ($this->Identity->get('isManager') || $this->Identity->get('isAdmin')): ?>
                        <div class="col-md-6 mb-3">
                            <?= $this->Form->control('user_id', [
                                'options' => $users,
                                'class' => 'form-select',
                                'label' => ['class' => 'form-label'],
                                'empty' => 'Select Employee',
                                'required'
                            ]) ?>
                        </div>
                    <?php endif; ?>
                    <div class="col-md-6 mb-3">
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
                    <div class="col-md-6 mb-3">
                        <?= $this->Form->control('start_date', [
                            'class' => 'form-control datepicker',
                            'type' => 'text',
                            'label' => ['class' => 'form-label'],
                            'required'
                        ]) ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <?= $this->Form->control('end_date', [
                            'class' => 'form-control datepicker',
                            'type' => 'text',
                            'label' => ['class' => 'form-label'],
                            'required'
                        ]) ?>
                    </div>
                    <div class="col-12 mb-3">
                        <?= $this->Form->control('reason', [
                            'class' => 'form-control',
                            'rows' => 3,
                            'label' => ['class' => 'form-label'],
                            'required'
                        ]) ?>
                    </div>
                    <?php if ($this->Identity->get('isManager') || $this->Identity->get('isAdmin')): ?>
                        <div class="col-md-6 mb-3">
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
                        <div class="col-12 mb-3">
                            <?= $this->Form->control('manager_comments', [
                                'class' => 'form-control',
                                'rows' => 3,
                                'label' => ['class' => 'form-label']
                            ]) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'btn btn-secondary me-md-2']) ?>
                    <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary']) ?>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</main>

<?php $this->append('script'); ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr(".datepicker", {
            dateFormat: "Y-m-d",
            minDate: "today",
            allowInput: true
        });

        // Bootstrap form validation
        (function () {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms)
                .forEach(function (form) {
                    form.addEventListener('submit', function (event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }
                        form.classList.add('was-validated')
                    }, false)
                })
        })()
    });
</script>
<?php $this->end(); ?>
