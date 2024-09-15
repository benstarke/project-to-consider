<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LeaveRequest $leaveRequest
 */
?>

<main>
    <div class="container-fluid px-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= $this->Url->buildFromPath('Pages::index') ?>" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= $this->Url->buildFromPath('LeaveRequests::index') ?>" class="text-decoration-none">Leave Requests</a></li>
                <li class="breadcrumb-item active" aria-current="page">View Leave Request</li>
            </ol>
        </nav>

        <h1 class="mt-4"><?= h($leaveRequest->leave_type) ?> Leave Request</h1>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-eye me-1"></i>
                Leave Request Details
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th class="w-25"><?= __('User') ?></th>
                        <td><?= $leaveRequest->user && $leaveRequest->user->f_name ? $this->Html->link($leaveRequest->user->f_name . ' ' . $leaveRequest->user->l_name, ['controller' => 'Users', 'action' => 'view', $leaveRequest->user->id]) : '' ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Leave Type') ?></th>
                        <td><?= h($leaveRequest->leave_type) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Status') ?></th>
                        <td><span class="badge bg-<?= $leaveRequest->status == 'approved' ? 'success' : ($leaveRequest->status == 'pending' ? 'warning' : 'danger') ?>"><?= h(ucfirst($leaveRequest->status)) ?></span></td>
                    </tr>
                    <tr>
                        <th><?= __('Start Date') ?></th>
                        <td><?= h($leaveRequest->start_date->format('Y-m-d')) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('End Date') ?></th>
                        <td><?= h($leaveRequest->end_date->format('Y-m-d')) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Created') ?></th>
                        <td><?= h($leaveRequest->created->format('Y-m-d H:i:s')) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Modified') ?></th>
                        <td><?= h($leaveRequest->modified->format('Y-m-d H:i:s')) ?></td>
                    </tr>
                </table>

                <div class="mt-4">
                    <h4><?= __('Reason') ?></h4>
                    <div class="card">
                        <div class="card-body">
                            <?= $this->Text->autoParagraph(h($leaveRequest->reason)); ?>
                        </div>
                    </div>
                </div>

                <?php if (!empty($leaveRequest->manager_comments)): ?>
                <div class="mt-4">
                    <h4><?= __('Manager Comments') ?></h4>
                    <div class="card">
                        <div class="card-body">
                            <?= $this->Text->autoParagraph(h($leaveRequest->manager_comments)); ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <div class="mt-4">
                    <?= $this->Html->link(__('Edit Leave Request'), ['action' => 'edit', $leaveRequest->id], ['class' => 'btn btn-primary']) ?>
                    <?= $this->Html->link(__('Back to List'), ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
                </div>
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