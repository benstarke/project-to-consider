<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\LeaveRequest[]|\Cake\Collection\CollectionInterface $leaveRequests
 */
?>
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.bootstrap5.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.bootstrap5.min.css" />
<script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.7/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.bootstrap5.js"></script>
<?= $this->Html->css(['customisetable']) ?>

<main>
    <div class="container-fluid px-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= $this->Url->buildFromPath('Pages::index') ?>" class="text-decoration-none">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Manage Leave Requests</li>
            </ol>
        </nav>
        
        <h1 class="mt-4">Manage Leave Requests</h1>
        
        <div class="mb-4">
            <?= $this->Flash->render() ?>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <table id="leaveRequestsTable" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                    <thead>
                        <tr>
                            <th><?= $this->Paginator->sort('user_id', 'Employee') ?></th>
                            <th><?= $this->Paginator->sort('leave_type') ?></th>
                            <th><?= $this->Paginator->sort('start_date') ?></th>
                            <th><?= $this->Paginator->sort('end_date') ?></th>
                            <th><?= $this->Paginator->sort('reason') ?></th>
                            <th><?= $this->Paginator->sort('created') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($leaveRequests as $leaveRequest): ?>
                        <tr>
                            <td>
                                <?php
                                if ($leaveRequest->has('user')) {
                                    $fullName = trim($leaveRequest->user->f_name . ' ' . $leaveRequest->user->l_name);
                                    echo $this->Html->link($fullName ?: $leaveRequest->user->email, ['controller' => 'Users', 'action' => 'view', $leaveRequest->user->id], ['class' => 'text-decoration-none']);
                                } else {
                                    echo __('N/A');
                                }
                                ?>
                            </td>
                            <td><?= h($leaveRequest->leave_type) ?></td>
                            <td><?= h($leaveRequest->start_date->format('Y-m-d')) ?></td>
                            <td><?= h($leaveRequest->end_date->format('Y-m-d')) ?></td>
                            <td><?= h($leaveRequest->reason) ?></td>
                            <td><?= h($leaveRequest->created->format('Y-m-d H:i:s')) ?></td>
                            <td class="actions">
    <?= $this->Html->link(__('View'), ['action' => 'view', $leaveRequest->id], ['class' => 'btn btn-sm btn-primary']) ?>
    <?= $this->Form->postLink(__('Approve'), 
        ['action' => 'approve', $leaveRequest->id],
        ['confirm' => __('Are you sure you want to approve the leave request for {0}?', $fullName),
         'class' => 'btn btn-sm btn-success']
    ) ?>
    <?= $this->Form->postLink(__('Deny'), 
        ['action' => 'deny', $leaveRequest->id],
        ['confirm' => __('Are you sure you want to deny the leave request for {0}?', $fullName),
         'class' => 'btn btn-sm btn-danger']
    ) ?>
</td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="paginator">
            <ul class="pagination">
                <?= $this->Paginator->first('<< ' . __('first')) ?>
                <?= $this->Paginator->prev('< ' . __('previous')) ?>
                <?= $this->Paginator->numbers() ?>
                <?= $this->Paginator->next(__('next') . ' >') ?>
                <?= $this->Paginator->last(__('last') . ' >>') ?>
            </ul>
            <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
        </div>
    </div>
</main>

<script>
$(document).ready(function () {
    $('#leaveRequestsTable').DataTable({
        responsive: true,
        columnDefs: [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: -1 }
        ],
        paging: false
    });
});
</script>