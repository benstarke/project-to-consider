<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Roster> $rosters
 */

?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.dataTables.css" />
<script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.dataTables.js"></script>
<?= $this->Html->css(['customisetable']) ?>
<main>
    <div class="">
        <nav class="bg-light d-flex justify-content-between align-items-center">
            <div class="ml-5 mr-3">
                <h3 class='text-primary'"><?= __('Roster & Shift Management') ?></h3>
                <ol class="breadcrumb" style="margin: 0;">
                    <li class="breadcrumb-item text-decoration-none"><a href="<?= $this->Url->buildFromPath('Pages::index') ?>" class='text-decoration-none text-info'>Dashboard</a></li>
                    <?= $this->Html->link(__('Rosters'), ['action' => 'index'], ['class' => 'breadcrumb-item active text-decoration-none']) ?>
                </ol>
            </div>
            <div>
                <a href="<?= $this->Url->build(['action' => 'calendar']) ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                    <i class="fas fa-calendar fa-sm text-white-50"></i> Calendar View</a>
                <a href="<?= $this->Url->build(['action' => 'add']) ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                    <i class="fas fa-plus fa-sm text-white-50" ></i> New Roster</a>
            </div>
        </nav>
        <div class="position-absolute top-0 end-0 p-2">
        <?= $this->Flash->render() ?>
    </div>
    </div>
    <br>
    <div class="rosters index content">
        <div class="breadcrumb-item text-decoration-none" style="text-align: center; font-weight: bold; font-size: 1.2em;"></div>
        <div class ="ml-5">
            <div class="table-responsive text-info">
                <table id="tblContain" class="display text-secondary nowrap =" style="width:100%" >
                    <thead>
                    <th>Roster Start Date</th>
                    <th>Roster End Date</th>
                    <th>Name</th>
                    <th>Shifts Associated</th>
                    <th>Actions</th>
                    </thead>
                    <tfoot>
                    <th>Roster Start Date</th>
                    <th>Roster End Date</th>
                    <th>Name</th>
                    <th>Shifts Associated</th>
                    <th>Actions</th>
                    </tfoot>
                    <tbody>
                    <?php foreach ($rosters as $roster) : ?>
                        <tr>
                            <td><?= h($roster->roster_date->format('d/m/y')) ?></td>
                            <td><?= h($roster->end_date->format('d/m/y')) ?></td>
                            <td><?= $roster->name ?></td>
                            <td class="text-center"><?= $roster->shift_count ?> shifts</td>
                            <td class="actions">
                            <a href="<?= $this->Url->buildFromPath('Shifts::add', [$roster->id]) ?>" class="table-link">
                                <span class="fa-stack" data-bs-toggle="tooltip" data-bs-title="Manage Shifts">
                                <i class="fa fa-square fa-stack-2x" style="color:#2B8EC6;"></i>
                                <i class="fa fa-table fa-stack-1x fa-inverse"></i>
                                </span>
                            </a>
                                <!-- <?= $this->Html->link(__('View'), ['action' => 'view', $roster->id], ['class' => 'btn btn-sm btn-outline-primary text-decoration-none']) ?><span> |</span> -->
                                <!-- <?= $this->Html->link(__('View Shifts'), ['controller' => 'Shifts','action' => 'add', $roster->id], ['class' => 'btn btn-sm btn-outline-primary text-decoration-none']) ?> -->
                                <a href="<?= $this->Url->buildFromPath('Rosters::edit', [$roster->id]) ?>" class="table-link">
                                <span class="fa-stack" data-bs-toggle="tooltip" data-bs-title="Edit Roster">
                                    <i class="fa fa-square fa-stack-2x" style="color: #2BC6B1;" ></i>
                                    <i class="fa fa-pencil fa-stack-1x fa-inverse"></i>
                                </span>
                            </a>
                                <?= $this->Form->postLink('
                                <span class="fa-stack" data-bs-toggle="tooltip" data-bs-title="Remove Roster">
                                <i class="fa fa-square fa-stack-2x"  style="color: #FF3333;"></i>
                                <i class="fa-solid fa-trash fa-stack-1x" style="color: #ffffff;"></i>
                                </span> ' . __(''), ['action' => 'delete', $roster->id], ['escapeTitle' => false, 'confirm' => __("Are you sure you want to delete {0}?", $roster->name)]) ?>

                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script>
const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
$(document).ready(function() {
    var currentDate = new Date();
    // Adjust to get Monday of the current week
    var firstDay = formatDate(new Date(currentDate.setDate(currentDate.getDate() - currentDate.getDay() + 1)))

    var table = $('#tblContain').DataTable({
        responsive: true,
        columnDefs: [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: -1 }
        ],
        "createdRow": function(row, data, dataIndex) {
            var rowStartDate = data[0]; // Format date from the first column

            // Check if the first column date is the start of the current week
            if (rowStartDate == firstDay) {
                // Insert badge HTML into the first cell of the row
                console.log('hi');
                $(row).addClass('highlight'); // Add highlight class
                $('td:eq(0)', row).html(data[0] +' ' + '<span class="badge badge-info ml-5">Current Week</span> ');
            }
        }
    });
});

function formatDate(date) {
    var d = new Date(date),
        day = '' + d.getDate(),
        month = '' + (d.getMonth() + 1),
        year = d.getFullYear().toString().substr(-2);  // Get last two digits of the year

    if (day.length < 2)
        day = '0' + day;
    if (month.length < 2)
        month = '0' + month;

    return [day,month, year].join('/'); // Ensure this matches the input format mm/dd/yy
}

</script>


</main>
