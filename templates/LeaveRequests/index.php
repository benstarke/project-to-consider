<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\LeaveRequest> $leaveRequests
 */

// Add this function at the top of your file
function getStatusBadgeClass($status) {
    switch (strtolower($status)) {
        case 'approved':
            return 'success';
        case 'pending':
            return 'warning';
        case 'rejected':
            return 'danger';
        default:
            return 'secondary';
    }
}
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Leave Requests</h6>
                    <?= $this->Html->link(__('New Leave Request'), ['action' => 'add'], ['class' => 'btn btn-primary btn-sm']) ?>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="leaveRequestsTable" width="100%" cellspacing="0">
                            <thead class="thead-light">
                                <tr>
                                    <th><?= $this->Paginator->sort('user_id', 'Employee') ?></th>
                                    <th><?= $this->Paginator->sort('leave_type') ?></th>
                                    <th><?= $this->Paginator->sort('start_date') ?></th>
                                    <th><?= $this->Paginator->sort('end_date') ?></th>
                                    <th><?= $this->Paginator->sort('status') ?></th>
                                    <th><?= $this->Paginator->sort('created', 'Submitted') ?></th>
                                    <th class="actions"><?= __('Actions') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($leaveRequests as $leaveRequest): ?>
                                <tr>
                                    <td><?= $leaveRequest->hasValue('user') ? h($leaveRequest->user->f_name . ' ' . $leaveRequest->user->l_name) : '' ?></td>
                                    <td><?= h($leaveRequest->leave_type) ?></td>
                                    <td><?= h($leaveRequest->start_date->format('Y-m-d')) ?></td>
                                    <td><?= h($leaveRequest->end_date->format('Y-m-d')) ?></td>
                                    <td>
                                        <span class="badge badge-<?= getStatusBadgeClass($leaveRequest->status) ?>">
                                            <?= h($leaveRequest->status) ?>
                                        </span>
                                    </td>
                                    <td><?= h($leaveRequest->created->format('Y-m-d H:i')) ?></td>
                                    <td class="actions">
                                        <div class="btn-group" role="group" aria-label="Leave request actions">
                                            <?= $this->Html->link('<i class="fas fa-eye"></i>', ['action' => 'view', $leaveRequest->id], ['class' => 'btn btn-sm btn-info', 'escape' => false, 'title' => 'View']) ?>
                                            <?= $this->Html->link('<i class="fas fa-edit"></i>', ['action' => 'edit', $leaveRequest->id], ['class' => 'btn btn-sm btn-warning', 'escape' => false, 'title' => 'Edit']) ?>
                                            <?= $this->Form->postLink('<i class="fas fa-trash"></i>', ['action' => 'delete', $leaveRequest->id], ['confirm' => __('Are you sure you want to delete this leave request?'), 'class' => 'btn btn-sm btn-danger', 'escape' => false, 'title' => 'Delete']) ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-5">
            <div class="dataTables_info" role="status" aria-live="polite">
                <?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?>
            </div>
        </div>
        <div class="col-sm-12 col-md-7">
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-end">
                    <?= $this->Paginator->first('<< ' . __('First'), ['class' => 'page-item']) ?>
                    <?= $this->Paginator->prev('< ' . __('Previous'), ['class' => 'page-item']) ?>
                    <?= $this->Paginator->numbers(['class' => 'page-item']) ?>
                    <?= $this->Paginator->next(__('Next') . ' >', ['class' => 'page-item']) ?>
                    <?= $this->Paginator->last(__('Last') . ' >>', ['class' => 'page-item']) ?>
                </ul>
            </nav>
        </div>
    </div>
</div>

<?php $this->start('script'); ?>
<script>
$(document).ready(function() {
    $('#leaveRequestsTable').DataTable({
        "paging": false,
        "info": false,
        "responsive": true,
        "order": [[5, "desc"]], // Sort by the "Submitted" column (index 5) in descending order
    });
});
</script>
<?php $this->end(); ?>
