<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Task> $tasks
 */
?>

<link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.dataTables.css" />
<script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.dataTables.js"></script>
<?= $this->Html->css(['customisetable']) ?>

<style>
table td {
    max-width: 250px; 
    white-space: normal; 
    text-overflow: ellipsis; 
    word-wrap: break-word; 
    overflow: hidden; 
    vertical-align: top; 
}

.normal-task {
    color: green;
}

.critical-task {
    color: red;
}

.color-hint {
    display: inline-block;
    width: 15px;
    height: 15px;
    margin-right: 5px;
    vertical-align: middle;
    border-radius: 3px;
}

.color-hint.normal {
    background-color: green;
}

.color-hint.critical {
    background-color: red;
}

.task-legend {
    display: flex;
    justify-content: start;
    align-items: center;
    margin-top: 10px;
    margin-left: 20px;
}
.task-legend span {
    margin-right: 15px;
}
</style>

<main>
    <div class="">
        <nav class="bg-light d-flex justify-content-between align-items-center">
            <div class="ml-5 mr-3">
                <h3 class='text-primary'><?= __('Tasks on shifts') ?></h3>
                <ol class="breadcrumb" style="margin: 0;">
                    <li class="breadcrumb-item text-decoration-none"><a href="<?= $this->Url->buildFromPath('Pages::index') ?>" class='text-decoration-none text-info'>Dashboard</a></li>
                    <?= $this->Html->link(__('Tasks'), ['action' => 'index'], ['class' => 'breadcrumb-item active text-decoration-none']) ?>
                </ol>
            </div>
            <div class="position-absolute top-0 end-0 p-2">
                <?= $this->Flash->render() ?>
            </div>
        </nav>
    </div>
    <br>
    <div class="container mt-3">
        <div class="ml-5">
            <span><span class="color-hint normal"></span>Normal Task</span>
            <span><span class="color-hint critical"></span>Critical Task</span>
        </div>
        <table id="tblContain" class="display nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>Task Description</th>
                    <th>Status</th>
                    <th>Responsibility</th>
                    <th>Deadline</th>
                    <th>Staff</th>
                    <th>Role Position</th>
                    <th>Shift Times</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Task Description</th>
                    <th>Status</th>
                    <th>Responsibility</th>
                    <th>Deadline</th>
                    <th>Staff</th>
                    <th>Role Position</th>
                    <th>Shift Times</th>
                    <th>Actions</th>
                </tr>
            </tfoot>
            <tbody>
                <?php foreach ($tasks as $task) : ?>
                <?php 
                    $taskClass = ($task->description_color === 'red') ? 'critical-task' : 'normal-task';
                ?>
                <tr class="">
                    <td class="expandable-cell <?= $taskClass ?>"><?= h($task->description) ?></td> 
                    <td>
                        <?php
                            switch ($task->status) {
                                case 'In Process':
                                    echo '<span class="badge bg-warning">In Progress</span>';
                                    break;
                                case 'Pending':
                                    echo '<span class="badge bg-secondary">Pending</span>';
                                    break;
                                case 'Completed':
                                    echo '<span class="badge bg-success">Completed</span>';
                                    break;
                            }
                        ?>
                    </td>
                    <td class="expandable-cell"><?= h($task->responsibility) ?></td> 
                    <td><?= date('d/m/Y', strtotime($task->deadline)) ?></td>
                    <td><?= h($task->f_name) ?> <?= h($task->l_name) ?></td>
                    <td><?= h($task->role) ?></td>
                    <td><a href="<?= $this->Url->buildFromPath('Shifts::add',[$task->rosterid]) ?>" class="text-decoration-none" style="color:black;"><?= date('d/m/Y h:i A', strtotime($task->start)) ?></a></td>
                    <td class='text-center'>
                        <!-- Edit -->
                        <a href="<?= $this->Url->build(['action' => 'edit', $task->id]) ?>" class="btn btn-warning btn-sm" title="Edit">
                            <i class="fa fa-edit"></i>
                        </a>
                        <!-- Delete -->
                        <?= $this->Form->postLink('
                            <span class="fa-stack">
                            <i class="fa fa-square fa-stack-2x"  style="color: #FF3333;"></i>
                            <i class="fa-solid fa-trash fa-stack-1x" style="color: #ffffff;"></i>
                            </span> ' . __(''), ['action' => 'delete', $task->id], ['escapeTitle' => false, 'confirm' => __("Are you sure you want to delete {0}?", $task->id)]) ?>
                    </td>            
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>

<script>
$(document).ready(function () {
    // Initialize the DataTable with responsive settings
    var table = $('#tblContain').DataTable({
        responsive: true,
        columnDefs: [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: -1 }
        ],
        paging: false // Corrected to disable paging
    });

    $('.expandable-cell').on('click', function () {
        $(this).toggleClass('expanded-cell');
        if ($(this).hasClass('expanded-cell')) {
            $(this).css({
                'overflow': 'visible',
                'white-space': 'normal'
            });
        } else {
            $(this).css({
                'overflow': 'hidden',
                'white-space': 'nowrap'
            });
        }
    });
});
</script>