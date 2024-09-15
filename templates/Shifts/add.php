<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Shift $shift
 * @var \Cake\Collection\CollectionInterface|array<string> $rosters
 * @var \Cake\Collection\CollectionInterface|array<string> $roles
 * @var \Cake\Collection\CollectionInterface|array<string> $users
 * @var \Cake\Collection\CollectionInterface|array<string> $usersArr
 * @var \Cake\Collection\CollectionInterface|array<string> $userAvailabilities
 */

?>
<?= $this->Html->meta('csrfToken', $this->request->getAttribute('csrfToken')) ?>
<?= $this->Html->css(['shiftable']) ?>

                        <style>
    .icon-circle {
        border: 2px solid black; /* Sets the color and thickness of the circle */
        border-radius: 50%;    /* Creates the round shape */
        padding: 10px;         /* Adds space around the icon */
        display: inline-flex;  /* Aligns the icon properly within the circle */
        justify-content: center; /* Centers the icon horizontally */
        align-items: center;    /* Centers the icon vertically */
    }
</style>
<div class="rosters index content">
    <div class="">
        <nav class="bg-light d-flex justify-content-between align-items-center">
            <div class="ml-5 mr-3">
                <h3 class='text-primary'><?= __('Roster & Shift Management') ?></h3>
                <ol class="breadcrumb" style="margin: 0;">
                    <li class="breadcrumb-item text-decoration-none"><a href="<?= $this->Url->buildFromPath('Pages::index') ?>" class='text-decoration-none text-info'>Dashboard</a></li>
                    <?= $this->Html->link(__('Rosters'), ['controller' => 'Rosters', 'action' => 'index'], ['class' => 'breadcrumb-item active text-decoration-none']) ?>
                    <li class="breadcrumb-item text-decoration-none"><?= $roster->roster_date->format('d/m/Y') . ' to ' . $roster->end_date->format('d/m/Y') ?></li>

                </ol>
            </div>
            <div>
                <a href="<?= $this->Url->build(['controller' => 'Rosters', 'action' => 'index']) ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                    <i class="fas fa-list fa-sm text-white-50"></i> View All Rosters </a>
            </div>
        </nav>
        <div class="position-absolute top-0 end-0 p-2">
            <?= $this->Flash->render() ?>
            <div aria-live="polite" aria-atomic="true" style="position: relative; min-height: 200px;">
  <div id="toast-container" style="position: absolute; top: 0; right: 0;">
    <div id="toast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="toast-header">
        <strong class="mr-auto">Notification</strong>
        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="toast-body">
        <!-- Toast message will go here -->
      </div>
    </div>
  </div>
</div>

        </div>
    </div>
</div>

<br>
<div class="d-flex justify-content-between align-items-center ml-5 mr-5">
                        <div class="col">
                        <div class="row">
                            <h4 class="card-title"><?= $roster->name ?>  </h4>
                            <h4 class="card-title"><?= __('Roster from ') , h($roster->roster_date->format('d/m/Y')) . ' until ' . h($roster->end_date->format('d/m/Y'))?> <i class="fa-solid fa-question fa-l rounded-circle icon-circle ml-2" data-bs-toggle="popover" data-bs-placement="right" title="Tips" data-bs-content='Shifts had an icon mean a task assigned to it'></i></h4>
                        </div>
                        </div>



                        <div class="button-group">
                            <a href="<?= $this->Url->build(['controller' => 'Rosters','action' => 'index']) ?>" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
                                <i class="fas fa-sm text-white-50"></i> Back</a>

                        </div>
</div>

<div class="container mt-3 table-div">
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.dataTables.css" />
<script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.dataTables.js"></script>
    <div class="row-div">
        <!-- Headers for the 7 days -->
        <?php foreach (['Roles','Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $day) : ?>
            <div class="cell-div header-cell-div">
                <strong><?= $day ?></strong>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Replace with actual roles from your backend -->

    <?php foreach ($roles as $role) : ?>
    <div class="row-div">
        <div class="cell-div header-cell-div">
            <strong><?= h($role->name) ?></strong>
        </div>

        <?php for ($i = 0; $i < 7; $i++) : ?>
            <?php $shiftsForCell = [];?>
            <?php
            foreach ($shift_list as $shift) {
                if ($shift->role_id == $role->id && $shift->start_time->format('N') - 1 == $i) {
                    $shiftsForCell[] = $shift;
                }
            }
            ?>

            <div class="cell-div box-cell">
                <!-- Loop for shifts in the cell -->
                        <!-- having shift -->
                        <?php if (!empty($shiftsForCell)) : ?>
                            <?php foreach ($shiftsForCell as $shift) : ?>
                            <div class="shift-cell individual-cell" onclick="event.stopPropagation(); editShift('<?= h($shift->id) ?>','<?= h($role->id) ?>', '<?= $shift->start_time->format('H:i') ?>', '<?= $shift->end_time->format('H:i') ?>', '<?= h($shift->user_id) ?>', <?= $i ?>, '<?= $roster->roster_date->i18nFormat('yyyy-MM-dd') ?>')">
                                <?php foreach ($users as $user) : ?>
                                    <?php if ($user->id == $shift->user_id) : ?>
                                        <?php
                                        $taskFound = false;  // Flag to check if a task is assigned
                                        foreach ($tasks as $task) :
                                            if ($task->shift_id == $shift->id) :
                                                $taskFound = true;
                                                ?>
                                    <i class="fa-solid fa-clipboard-user mr-2" id="taskIcon"></i>
                                    <span data-toggle="tooltip" title="Click to Edit <?= h($user->f_name) ?>"><?= h($user->f_name) ?><br>(<?= h($shift->start_time->format('H:i')) ?>-<?= h($shift->end_time->format('H:i')) ?>)</span>
                                                <?php
                                            endif;
                                        endforeach;
                                        if (!$taskFound) :  // Check if no task was found
                                            // The task icon is hidden, nothing is output for the icon
                                            ?>
                                    <span data-toggle="tooltip" title="Click to Edit <?= h($user->f_name) ?>"><?= h($user->f_name) ?><br>(<?= h($shift->start_time->format('H:i')) ?>-<?= h($shift->end_time->format('H:i')) ?>)</span>

                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>

                        </div>
                            <?php endforeach; ?>
                        <?php endif; ?>

                <!-- Always display + symbol for adding a new shift -->
                <div class="add-shift shift-cell" onclick="addShift('<?= h($role->name) ?>', '<?= h($role->id) ?>', <?= $i ?>, '<?= $roster->roster_date->i18nFormat('yyyy-MM-dd') ?>')"><i class="fa-solid fa-plus"  data-toggle="tooltip" data-placement="left" title="Click to Add More Shifts"></i></div>

            </div>

        <?php endfor; ?>
    </div>
    <?php endforeach; ?>

</div>
<div class="container">
<div class="users index content mt-5 ml-2 mr-2 text-primary" >
    <div>
        <h4 class="text-primarys">Task List</h4>
        <table id="tblContain"  class="user-list display nowrap " style="width:100%" >
            <thead>
                <tr>
                    <th>Task Content</th>
                    <th>Responsibility</th>
                    <th>Status</th>
                    <th>Deadline</th>
                    <th>Accountable User</th>
                    <th>Role Position</th>
                    <th>Shift Times</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
        <?php foreach ($tasks as $task) : ?>
        <tr class="">
            <td><?= $task->description ?></td>
            <td><?= $task->responsibility ?></td>
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

            <td><?= date('d/m/Y', strtotime($task->deadline)) ?></td>
            <td><?= $task->f_name ?> <?= $task->l_name ?></td>
            <td><?= $task->role ?></td>
            <td><?= date('d/m/Y h:i A', strtotime($task->start)) ?></td>
            <td  class='text-center'>
                <!-- <a href="<?= $this->Url->build(['controller' => 'shifts','action' => 'tasksedit', $task->id]) ?>" class="btn btn-warning btn-sm" title="Edit">
                            <i class="fa fa-edit"></i>
                        </a> -->
                        
                <a href="<?= $this->Url->build(['controller' => 'tasks','action' => 'edit', $task->id]) ?>" class="btn btn-warning btn-sm" title="Edit">
                            <i class="fa fa-edit"></i>
                        </a>
                            <?= $this->Form->postLink('
                                <span class="fa-stack">
                                <i class="fa fa-square fa-stack-2x"  style="color: #FF3333;"></i>
                                <i class="fa-solid fa-trash fa-stack-1x" style="color: #ffffff;"></i>
                                </span> ' . __(''), ['controller'=>'Tasks','action' => 'delete', $task->id], ['escapeTitle' => false, 'confirm' => __("Are you sure you want to delete {0}?", $task->id)]) ?>

                    </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
        </table>
    </div>
</div>

</div>
<?= $this->Html->css(['customisetable']) ?>

<!-- Modal ADD-->
<div class="modal fade" id="shiftModal" tabindex="-1" aria-labelledby="shiftModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"  style="background-color: #7fcbae;">
            <h5 class="modal-title" id="shiftModalLabel">
                Add <span id="roleName" style="display: inline-block;"></span> on <span id="shiftDate"></span>
            </h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="closeAllModalClose"></button>
            </div>
            <div class="modal-body">
                <span style="color: grey;">
                    Please note:<br>
                    1. The end time should not be before the start time.<br>
                    2. The minimum shift duration should be more than 1 hour.<br>
                    3. The maximum shift duration cannot exceed 24 hours.
                </span>
                    <div id="shiftContent">
                        <?= $this->Form->create(null, ['url' => ['controller' => 'Shifts','action' => 'add',$roster->id]]); ?>
                        <div class="form-group">
    <?= $this->Form->hidden('shiftDate', ['id' => 'hiddenDate']) ?>
</div>
<div class="form-group">
    <?= $this->Form->hidden('role_id', ['id' => 'roleId']) ?>
</div>
<div class="form-group">
    <?= $this->Form->control('start_time', [
        'type' => 'time',
        'class' => 'form-control',
        'label' => ['text' => 'Start Time <span style="color: red;">*</span>','escape'=>false],
        'style' => 'width: 100%;',
        'step' => 60,
        'id' => 'shiftStart',
        'onchange' => 'validateTimeRange()',
    ]) ?>
    <div id="startTimeError" class="invalid-feedback">
        Start time is required.
    </div>
</div>
<div class="form-group">
    <?= $this->Form->control('end_time', [
        'type' => 'time',
        'class' => 'form-control',
        'label' => ['text' => 'End Time <span style="color: red;">*</span>','escape'=>false],
        'style' => 'width: 100%;',
        'step' => 60,
        'id' => 'shiftEnd',
        'onchange' => 'validateTimeRange()',
    ]) ?>
    <div id="endTimeError" class="invalid-feedback">
        End time cannot be before start time.
    </div>
</div>
<div class="form-group" id="user_ava"></div>

                    </div>
                    <div id="tasksContent"  style="display: none;">
                        <div class="mb-2">
                                    <label for="taskDescription" class="form-label">Task Description <span style="color: red;">*</span></label>
                                    <textarea class="form-control" id="taskDescription1" rows="5" placeholder="Describe the task..." maxlength="255"></textarea>
                                    <div id="taskDescription1Feedback" class="invalid-feedback">
                                    Task description is required.
                                    </div>
                        </div>
                        <div class="mb-2">
                            <label for="taskDeadline" class="form-label">Deadline <span style="color: red;">*</span></label>
                            <input type="datetime-local" class="form-control" id="taskDeadline1" name="taskDeadline">
                            <div id="taskDeadline1Feedback" class="invalid-feedback">
                                    Deadline is required and must be a valid date.
                                </div>
                        </div>

                        <div class="mb-2">
                                    <label for="taskResponsibility" class="form-label">Responsibility <span style="color: red;">*</span></label>
                                    <textarea class="form-control" id="taskResponsibility" rows="5" placeholder="Describe the responsibility..." maxlength="255"></textarea>
                                    <div id="taskResponsibilityFeedback" class="invalid-feedback">
                                    
                                    </div>
                        </div>

                        <div class="mb-2">
                            <input type="hidden" id="taskStatus1" name="taskStatus" value="Pending">
                        </div>
                    </div>
                    <div class="task-button-container text-center" style="color: grey;cursor: pointer" id="openTaskContent" onclick="toggleTasksContent('add')">
                        <span id="taskText"></span><br>
                        <i class="fa-solid " id="chevronIcon"></i>
                    </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal" aria-label="Close" id="closeAllModal">Close</button>
                <button type="button" class="text-decoration-none btn btn-sm btn-outline-info" id="submitAll">Submit</button>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>

<!-- Edit Shift Modal -->
<div class="modal fade" id="editShiftModal" tabindex="-1" role="dialog" aria-labelledby="editShiftModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header"  style="background-color: #7fcbae;">
            <h5 class="modal-title" id="shiftModalLabel">
                Edit on <span id="shiftDate1"></span>
            </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="closeEditModalClose"></button>
            </div>
            <div class="modal-body">
            <span class="mb-1" style="color: grey;">
                    Please note:<br>
                    1. The end time should not be before the start time.<br>
                    2. The minimum shift duration should be more than 1 hour.<br>
                    3. The maximum shift duration cannot exceed 24 hours.
                </span>
                <?= $this->Form->create(null, ['url' => ['controller' => 'Shifts', 'action' => 'edit','id' => 'modalShiftId']]) ?>
                <div class="form-group">
    <?= $this->Form->hidden('shiftId', ['id' => 'modalShiftId']) ?>
    <?= $this->Form->hidden('shiftDate', ['id' => 'hiddenDate1']) ?>
    <?= $this->Form->control('start_time', [
        'label' => 'Start Time <span style="color: red;">*</span>',
        'class' => 'form-control',
        'type' => 'time',
        'id' => 'modalShiftStartTime',
        'onchange' => 'validateEditTimeRange()',
        'escape' =>false,
    ]) ?>
    <div id="startTimeError" class="invalid-feedback">
        Start time is required.
    </div>

    <?= $this->Form->control('end_time', [
        'label' => 'End Time <span style="color: red;">*</span>',
        'class' => 'form-control',
        'type' => 'time',
        'id' => 'modalShiftEndTime',
        'onchange' => 'validateEditTimeRange()',
        'escape' =>false,
    ]) ?>
    <div id="endEditimeError" class="invalid-feedback">
        End time cannot be before start time.
    </div>

    <div class="form-group" id="user_ava_edit"></div>
</div>

                <div id="editTaskContent"  style="display: none;">
                        <?= $this->Form->hidden('taskid', ['id' => 'modalTaskId']) ?>
                        <form id="editTaskForm">
                            <div class="mb-2">
                                <label for="editTaskDescription" class="form-label">Task Description <span style="color: red;">*</span></label>
                                <textarea class="form-control" id="editTaskDescription" rows="5" placeholder="Describe the task..." maxlength="255"></textarea>
                                <div id="editTaskDescriptionFeedback" class="invalid-feedback">
                                    Task description is required.
                                </div>
                            </div>
                            <div class="mb-2">
                                <label for="editTaskDeadline" class="form-label">Deadline <span style="color: red;">*</span></label>
                                <input type="datetime-local" class="form-control" id="editTaskDeadline" name="taskDeadline">
                                <div id="editTaskDeadlineFeedback" class="invalid-feedback">
                                    Deadline is required and must be a valid date.
                                </div>
                            </div>
                            <div class="mb-2">
                                <label for="editResponsibility" class="form-label">Responsibility <span style="color: red;">*</span></label>
                                <textarea class="form-control" id="editResponsibility" rows="5" placeholder="Describe the responsibility..." maxlength="255"></textarea>
                                <div id="editResponsibilityFeedback" class="invalid-feedback">
                                    
                                </div>
                            </div>
                            <div class="mb-2">
                                <input type="hidden" id="editTaskStatus" value="Pending">
                            </div>
                        </form>

                </div>
                <div class="task-button-container text-center" style="color: grey;cursor: pointer" id="openTaskContent" onclick="toggleTasksContent('edit')">
                        <span id="taskTextEdit"></span>
                        <i class="fa-solid " id="chevronIconEdit"></i>
                    </div>
            </div>
            <div class="modal-footer">
                <!-- Inside your modal body, after the existing form -->
                <button type="button" class="btn btn-secondary btn-sm float-left" data-bs-dismiss="modal" id="closeEditModal">Close</button>
                <button onclick="deleteShift()"  type="button" class="text-decoration-none btn btn-sm btn-outline-danger" data-bs-dismiss="modal">Remove Shift</button>
                <button onclick="deletetask()"  id="deletetaskbutton" type="button" class="text-decoration-none btn btn-sm btn-outline-danger" data-bs-dismiss="modal">Remove Tasks</button>
                <button type="button" class="text-decoration-none btn btn-sm btn-outline-info" id="updateAll">Update</button>
                <!-- <?= $this->Form->button(__('Update'), ['type' => 'submit', 'class' => 'text-decoration-none btn btn-sm btn-outline-info', 'onClick' => 'return validateEditTimeRange();']) ?> -->
                <?= $this->Form->end() ?>


            </div>

        </div>
    </div>
</div>
<script>
$(document).ready(function () {
    // Initialize the DataTable with responsive settings
    var table = $('#tblContain123').DataTable({
        responsive: true,
        columnDefs: [
            { responsivePriority: 1, targets: 0 },
            { responsivePriority: 2, targets: -1 }
        ],
        paging: false // Corrected to disable paging
    });
});
</script>


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>



<script>
var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
  return new bootstrap.Popover(popoverTriggerEl)
})
function toggleTasksContent(method) {

    var tasksContent;

    if (method === "add") {
        tasksContent = document.getElementById('tasksContent');
            // Toggling the text and icon of the button
        var textElement = document.getElementById('taskText');
        var iconElement = document.getElementById('chevronIcon');
    } else if (method === 'edit') {
        tasksContent = document.getElementById('editTaskContent');
        var textElement = document.getElementById('taskTextEdit');
        var iconElement = document.getElementById('chevronIconEdit');
    }
    // Toggling the tasks display

    if (tasksContent.style.display === 'block') {
        tasksContent.style.display = 'none';
    } else {
        tasksContent.style.display = 'block';
    }

    if (textElement.innerText === "Add more task") {
        textElement.innerText = "Discard add task";
        iconElement.classList.remove('fa-chevron-down');
        iconElement.classList.add('fa-chevron-up');
    } else {
        textElement.innerText = "Add more task";
        iconElement.classList.remove('fa-chevron-up');
        iconElement.classList.add('fa-chevron-down');
        if (method === "add") {
            document.getElementById('taskDescription1').value = '';
            document.getElementById('taskResponsibility').value = '';
            document.getElementById('taskDeadline1').value = '';
            document.getElementById('taskStatus1').value = 'Pending';
        }else if (method === "edit") {
            document.getElementById('editTaskDescription').value = '';
            document.getElementById('editResponsibility').value = '';
            document.getElementById('editTaskDeadline').value = '';
            document.getElementById('editTaskStatus').value = 'Pending';
        }
    }
}

</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
var shiftModal = new bootstrap.Modal(document.getElementById('shiftModal'));
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})



$(document).ready(function() {
    if (localStorage.getItem('showToast') === 'true') {
                // Get the message and status from local storage
                var toastMessage = localStorage.getItem('toastMessage');
                var status = localStorage.getItem('status');

                // Display your toast notification here
                var toastElement = $('#toast');
                var toastheader = toastElement.find('.toast-header');
                var toastBody = toastElement.find('.toast-body');

                toastBody.text(toastMessage);

                // Add the appropriate class based on the status
                if (status === 'success') {
                    toastElement.addClass('border-success text-success');
                    toastheader.addClass('bg-success text-white');
                } else if (status === 'error') {
                    toastElement.addClass('border-danger text-danger');
                    toastheader.addClass('bg-danger text-white ')
                }

                // Show the toast
                toastElement.toast('show');

                // Clear the flags
                localStorage.removeItem('showToast');
                localStorage.removeItem('toastMessage');
                localStorage.removeItem('status');
            }
});

function showToast(message) {
    // Assuming you're using Bootstrap for toast, or you can adapt it to your toast library
    var toastElement = $('#toast');
    toastElement.find('.toast-body').text(message); // Set the message
    toastElement.toast('show');
}
$(document).ready(function() {
    $('#editTaskDescription').on('change', validateTaskDescription);
    $('#editResponsibility').on('change', validateTaskResponsibility);
    $('#editTaskDeadline').on('change', validateTaskDeadline);
    $('#taskDescription1').on('change', editvalidateTaskDescription);
    $('#taskResponsibility').on('change', editvalidateTaskResponsibility);
    $('#taskDeadline1').on('change', editvalidateTaskDeadline);
})
function validateTimeRange() {
    var startTimeInput = document.getElementById('shiftStart');
    var endTimeInput = document.getElementById('shiftEnd');
    var endTimeError = document.getElementById('endTimeError');
    var startTimeError = document.getElementById('startTimeError'); // Assuming there's an element to show start time errors

    var result = true;

    // Check if start time or end time inputs are empty
    if (!startTimeInput.value || !endTimeInput.value) {
        if (!startTimeInput.value) {
            startTimeInput.classList.add('is-invalid');
            if (startTimeError) { // Check if the error element exists
                startTimeError.textContent = 'Start time cannot be empty'; // Set error message
                startTimeError.style.display = 'block';
            }
        }
        if (!endTimeInput.value) {
            endTimeInput.classList.add('is-invalid');
            if (endTimeError) { // Check if the error element exists
                endTimeError.textContent = 'End time cannot be empty'; // Set error message
                endTimeError.style.display = 'block';
            }
        }
        return false; // Return false as the validation failed
    }

    // Create Date objects for comparison
    var startTime = new Date('1970-01-01T' + startTimeInput.value + ':00');
    var endTime = new Date('1970-01-01T' + endTimeInput.value + ':00');
    var timeDifference = endTime - startTime;

    // Convert milliseconds to hours
    var duration = timeDifference / (1000 * 60 * 60);

    // Validate the time range
    if (endTime < startTime) {
        // End time is before start time
        endTimeInput.classList.add('is-invalid');
        endTimeError.textContent = 'End time cannot be before start time';
        endTimeError.style.display = 'block';
        startTimeInput.classList.remove('is-invalid');
        if (startTimeError) startTimeError.style.display = 'none';
        result = false;
    } else if (duration > 24) {
        // Duration is more than 24 hours
        endTimeInput.classList.add('is-invalid');
        endTimeError.textContent = 'The maximum time cannot be more than 24 hours';
        endTimeError.style.display = 'block';
        startTimeInput.classList.remove('is-invalid');
        if (startTimeError) startTimeError.style.display = 'none';
        result = false;
    } else if (duration < 1) {
        // Duration is less than 1 hour
        endTimeInput.classList.add('is-invalid');
        endTimeError.textContent = 'The minimum time cannot be less than 1 hour';
        endTimeError.style.display = 'block';
        startTimeInput.classList.remove('is-invalid');
        if (startTimeError) startTimeError.style.display = 'none';
        result = false;
    } else {
        // Both times are valid
        startTimeInput.classList.remove('is-invalid');
        if (startTimeError) startTimeError.style.display = 'none';
        endTimeInput.classList.remove('is-invalid');
        endTimeError.style.display = 'none';
    }

    return result;
}
function validateEditTimeRange() {
        var startTimeInput = document.getElementById('modalShiftStartTime');
        var endTimeInput = document.getElementById('modalShiftEndTime');
        var startTime = new Date('1970-01-01T' + startTimeInput.value);
        var endTime = new Date('1970-01-01T' + endTimeInput.value);
        var startTimeError = document.getElementById('startTimeError');
        var endTimeError = document.getElementById('endEditimeError');
        var result = true;

        // Calculate the duration in hours
        var duration = (endTime - startTime) / (1000 * 60 * 60); // Duration in hours

        // Validate the duration is at least 1 hour
        if(endTime < startTime){
            endTimeInput.classList.add('is-invalid');
            endTimeError.textContent = 'End time cannot be before start time';
            endTimeError.style.display = 'block';
            result = false;
        }else if (duration < 1) {
            endTimeInput.classList.add('is-invalid');
            endTimeError.textContent = 'Duration must be at least 1 hour';
            endTimeError.style.display = 'block';
            result = false;
        } else if (duration > 24) {
            // Validate the duration is not more than 24 hours
            endTimeInput.classList.add('is-invalid');
            endTimeError.textContent = 'Duration cannot exceed 24 hours';
            endTimeError.style.display = 'block';
            result = false;
        } else {
            endTimeInput.classList.remove('is-invalid');
            endTimeError.style.display = 'none';
        }

        return result;
    }
async function editShift(shiftId, roleId, startTime, endTime, modalUserId, dayIndex, rosterStartDate) {
    // Initialize modal and icons
    var textElement = document.getElementById('taskTextEdit');
    var iconElement = document.getElementById('chevronIconEdit');
    textElement.innerText = "Add more task";
    iconElement.classList.add('fa-chevron-down');

    var editShiftModal = new bootstrap.Modal(document.getElementById('editShiftModal'));
    editShiftModal.show();

    // Populate modal fields
    document.getElementById('modalShiftId').value = shiftId;
    document.getElementById('modalShiftStartTime').value = startTime;
    document.getElementById('modalShiftEndTime').value = endTime;

    // Handle date calculations for shift
    var rosterStart = new Date(rosterStartDate);
    var rosterStartDayIndex = rosterStart.getDay();
    var adjustedDayIndex = dayIndex - (rosterStartDayIndex === 0 ? -6 : rosterStartDayIndex - 1);
    adjustedDayIndex = adjustedDayIndex < 0 ? adjustedDayIndex + 7 : adjustedDayIndex;

    var shiftDate = new Date(rosterStart);
    shiftDate.setDate(rosterStart.getDate() + adjustedDayIndex);
    var options = { day: 'numeric', month: 'numeric', year: 'numeric', weekday: 'long' };
    var formattedDate = shiftDate.toLocaleDateString('en-GB', options).replace(',', '');
    document.getElementById('shiftDate1').textContent = formattedDate;
    document.getElementById('hiddenDate1').value = shiftDate.toISOString().split('T')[0];
    // Setup dropdown for employee selection
    setupEmployeeDropdown(dayIndex, modalUserId);

    // Clear previous task data
    clearTaskData();

    // Fetch and handle task data
    var initialtask = await fetchAndHandleTaskData(shiftId);

    // Remove previous event listener and add a new one
    var updateAllButton = document.getElementById('updateAll');
    updateAllButton.replaceWith(updateAllButton.cloneNode(true));
    updateAllButton = document.getElementById('updateAll');

    document.getElementById('closeEditModalClose').addEventListener('click', function () {
    editShiftModal.hide();
    });
document.getElementById('closeEditModal').addEventListener('click', function () {
    editShiftModal.hide();
    });

    updateAllButton.addEventListener('click', async function(event) {
        var result = initialtask;
        // validateTaskDescription() && validateTaskDeadline() &&
        if( validateEditTimeRange()){
            if (result === true) {
            var tasksData = await updateTaskData();
            var shiftData = {
                roster_id: '<?= $roster->id ?>',
                shiftDate: document.getElementById('hiddenDate1').value,
                role_id: roleId,
                start_time:  document.getElementById('modalShiftStartTime').value,
                end_time: document.getElementById('modalShiftEndTime').value,
                user_id: document.getElementById('user_id').value,
                shift_id:shiftId
            };
            $.ajax({
                type: 'GET', // Ensure this is the correct method, typically 'POST' or 'PATCH' for edit operations
                url: '<?= $this->Url->build(['controller' => 'Shifts', 'action' => 'edit']) ?>',
                data: { data: shiftData },
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                },
                success: function (response) {
                    // Assuming the response contains the message in JSON format
                    console.log(response);
                    if (response.message) {
                        localStorage.setItem('toastMessage', response.message); // Store the message
                        localStorage.setItem('showToast', 'true'); // Set flag in local storage
                        localStorage.setItem('status', response.status);
                    }
                    editShiftModal.hide();
                    $('.table-div').html(); // Update your table div if necessary
                    window.location.reload(); // Reload the page to show the toast
                },
                error: function(xhr, status, error) {
                    localStorage.setItem('toastMessage', 'An error occurred: ' + error); // Store AJAX error message
                    localStorage.setItem('showToast', 'true'); // Set flag in local storage
                    localStorage.setItem('status', response.status);
                    window.location.reload(); // Reload the page to show the toast
                    console.error("Task submission error: " + error);
                }
            });
            if(validateTaskDescription() && validateTaskDeadline()){
            $.ajax({
                type: 'GET', // Ensure this is the correct method, typically 'POST' or 'PATCH' for edit operations
                url: '<?= $this->Url->build(['controller' => 'Tasks', 'action' => 'edit'] ) ?>',
                data: { data: tasksData },
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                },
                success: function (response) {
                    // Assuming the response contains the message in JSON format
                    if (response.message) {
                        localStorage.setItem('toastMessage', response.message); // Store the message
                        localStorage.setItem('status', response.status);
                        localStorage.setItem('showToast', 'true'); // Set flag in local storage
                    }
                    editShiftModal.hide();
                    $('.table-div').html(); // Update your table div if necessary
                    window.location.reload(); // Reload the page to show the toast
                },
                error: function(xhr, status, error) {
                    localStorage.setItem('toastMessage', 'An error occurred: ' + error); // Store AJAX error message
                    localStorage.setItem('showToast', 'true'); // Set flag in local storage
                    window.location.reload(); // Reload the page to show the toast
                    console.error("Task submission error: " + error);
                }
            });
        }
            } else {
            var tasksData = await addTask(shiftId);
            console.log('false', tasksData);
            var shiftData = {
                roster_id: '<?= $roster->id ?>',
                shiftDate: document.getElementById('hiddenDate1').value,
                role_id: roleId,
                start_time:  document.getElementById('modalShiftStartTime').value,
                end_time: document.getElementById('modalShiftEndTime').value,
                user_id: document.getElementById('user_id').value,
                shift_id:shiftId
            };
            $.ajax({
                type: 'GET', // Ensure this is the correct method, typically 'POST' or 'PATCH' for edit operations
                url: '<?= $this->Url->build(['controller' => 'Shifts', 'action' => 'edit']) ?>',
                data: { data: shiftData },
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                },
                success: function (response) {
                    // Assuming the response contains the message in JSON format
                    if (response.message) {
                        localStorage.setItem('toastMessage', response.message); // Store the message
                        localStorage.setItem('status', response.status); // Store the message
                        localStorage.setItem('showToast', 'true'); // Set flag in local storage
                    }
                    editShiftModal.hide();
                    $('.table-div').html(); // Update your table div if necessary
                    window.location.reload(); // Reload the page to show the toast
                },
                error: function(xhr, status, error) {
                    localStorage.setItem('toastMessage', 'An error occurred: ' + error); // Store AJAX error message
                    localStorage.setItem('showToast', 'true'); // Set flag in local storage
                    window.location.reload(); // Reload the page to show the toast
                    console.error("Task submission error: " + error);
                }
            });


            if(validateTaskDescription() && validateTaskDeadline()){
                $.ajax({
                type: 'GET', // Typically should be 'POST' for adding new data
                url: '<?= $this->Url->build(['controller' => 'Tasks', 'action' => 'add']) ?>',
                data: { data: tasksData },
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                },
                success: function(response) {
                    // Assuming the response contains the message in JSON format
                    if (response.message) {
                        localStorage.setItem('toastMessage', response.message); // Store the message
                        localStorage.setItem('status', response.status);
                        localStorage.setItem('showToast', 'true'); // Set flag in local storage
                    }
                    // editShiftModal.hide();
                    // $('.table-div').html(); // Update your table div if necessary
                    // window.location.reload(); // Reload the page to show the toast
                },
                error: function(xhr, status, error) {
                    localStorage.setItem('toastMessage', 'An error occurred: ' + error); // Store AJAX error message
                    localStorage.setItem('showToast', 'true'); // Set flag in local storage
                    // window.location.reload(); // Reload the page to show the toast
                    // console.error("Task submission error: " + error);
                }
            });
            }
            }
        }
    });
}

async function fetchAndHandleTaskData(shiftId) {
    try {
        const taskData = await $.ajax({
            url: '<?= $this->Url->build(['controller' => 'tasks', 'action' => 'getTasks']) ?>',
            method: 'GET',
            data: { data: shiftId }
        });

        if (taskData && !taskData.error) {
            // Set form values from taskData
            document.getElementById('editTaskDescription').value = taskData.description;
            document.getElementById('editResponsibility').value = taskData.responsibility;
            document.getElementById('editTaskDeadline').value = convertDatetime12(taskData.deadline);
            document.getElementById('editTaskStatus').value = taskData.status;
            document.getElementById('modalTaskId').value = taskData.id;
            document.getElementById('editTaskContent').style.display = 'block';
            document.getElementById('taskTextEdit').style.display = 'none';
            document.getElementById('chevronIconEdit').style.display = 'none';

            return true;
        } else {
            console.log('No task found');
             document.getElementById('deletetaskbutton').style.display = 'none'; // Hide the delete task button
             document.getElementById('editTaskContent').style.display = 'none';
             document.getElementById('taskTextEdit').style.display = 'block';
            document.getElementById('chevronIconEdit').style.display = 'block';
            clearTaskData();
            return false;
        }
    } catch (error) {
        console.log('Error fetching task data');
        clearTaskData();
        return false;
    }
}

function clearTaskData() {
    document.getElementById('editTaskDescription').value = '';
    document.getElementById('editResponsibility').value = '';
    document.getElementById('editTaskDeadline').value = '';
    document.getElementById('editTaskStatus').value = 'Pending';
    document.getElementById('modalTaskId').value = 0;
}

async function updateTaskData() {
    var taskData = {
        id: document.getElementById('modalTaskId').value,
        description: document.getElementById('editTaskDescription').value,
        responsibility: document.getElementById('editResponsibility').value,
        deadline: document.getElementById('editTaskDeadline').value,
        status: document.getElementById('editTaskStatus').value
    };
    return taskData;
}

async function addTask(shiftId) {
    var taskData = {
        shift_id: shiftId,
        description: document.getElementById('editTaskDescription').value,
        responsibility: document.getElementById('editResponsibility').value,
        deadline: convertDatetime12(document.getElementById('editTaskDeadline').value),
        status: document.getElementById('editTaskStatus').value
    };
    return taskData;
}

function setupEmployeeDropdown(dayIndex, modalUserId) {
    var s = '<label for="user_id">Employee <span style="color: red;">*</span></label><select class="form-control" name="user_id" id="user_id">';
    var t = '';
    var ava = <?php echo json_encode($userAvailabilities) ?>;
    var usersArr = <?php echo json_encode($usersArr) ?>;
    var dateMap = {
        0: 'monday', 1: 'tuesday', 2: 'wednesday',
        3: 'thursday', 4: 'friday', 5: 'saturday', 6: 'sunday'
    };
    var date_key = dateMap[dayIndex];

    $.each(usersArr, function(kk, vv) {
        if (vv.isAdmin == 0) {
            $.each(ava, function(k, v) {
                if (v.user_id === vv.id && v[date_key]) {
                    t += `<option value="${vv.id}">${vv.logic_name}</option>`;
                    return false; // Breaks the inner loop early
                }
            });
        }
    });
    s += t + '</select>';
    $('#user_ava_edit').empty().html(s);
    $('#user_id').val(modalUserId);
}
function validateTaskResponsibility() {
        var taskDescription = $('#editResponsibility').val().trim();
        if (!taskDescription) {
            $('#editResponsibility').addClass('is-invalid');
            $('#editResponsibilityFeedback').show();
            return false;
        } else {
            $('#editResponsibility').removeClass('is-invalid');
            $('#editResponsibilityFeedback').hide();
            return true;
        }
    }
function validateTaskDescription() {
        var taskDescription = $('#editTaskDescription').val().trim();
        if (!taskDescription) {
            $('#editTaskDescription').addClass('is-invalid');
            $('#editTaskDescriptionFeedback').show();
            return false;
        } else {
            $('#editTaskDescription').removeClass('is-invalid');
            $('#editTaskDescriptionFeedback').hide();
            return true;
        }
    }
function editvalidateTaskResponsibility() {
        var taskDescription = $('#taskResponsibility').val().trim();
        if (!taskDescription) {
            $('#taskResponsibility').addClass('is-invalid');
            $('#taskResponsibilityFeedback').show();
            return false;
        } else {
            $('#taskResponsibility').removeClass('is-invalid');
            $('#taskResponsibilityFeedback').hide();
            return true;
        }
    }    
function editvalidateTaskDescription() {
        var taskDescription = $('#taskDescription1').val().trim();
        if (!taskDescription) {
            $('#taskDescription1').addClass('is-invalid');
            $('#taskDescription1Feedback').show();
            return false;
        } else {
            $('#taskDescription1').removeClass('is-invalid');
            $('#taskDescription1Feedback').hide();
            return true;
        }
    }
function validateTaskDeadline() {
        var taskDeadline = $('#editTaskDeadline').val();
        var shiftDate = document.getElementById('hiddenDate1').value;
        var startTime = document.getElementById('modalShiftStartTime').value;
        var endTime = document.getElementById('modalShiftEndTime').value;

        // Convert the shift start and end times to Date objects
        var shiftStartDateTime = new Date(shiftDate + 'T' + startTime + ':00');
        var shiftEndDateTime = new Date(shiftDate + 'T' + endTime + ':00');
        var taskDeadlineDateTime = new Date(taskDeadline);

        console.log('Shift Start:', shiftStartDateTime);
        console.log('Shift End:', shiftEndDateTime);
        console.log('Task Deadline:', taskDeadlineDateTime);

        // Validate if task deadline is within the shift time range
        if (!taskDeadline || taskDeadlineDateTime < shiftStartDateTime || taskDeadlineDateTime > shiftEndDateTime) {
            $('#editTaskDeadline').addClass('is-invalid');
            $('#editTaskDeadlineFeedback').text('Deadline must be within the shift time range.').show();
            return false;
        } else {
            $('#editTaskDeadline').removeClass('is-invalid');
            $('#editTaskDeadlineFeedback').hide();
            return true;
        }
    }
// Additional utility functions and event handlers as needed
function editvalidateTaskDeadline() {
        var taskDeadline = $('#taskDeadline1').val();
        var shiftDate = document.getElementById('hiddenDate').value;
        var startTime = document.getElementById('shiftStart').value;
        var endTime = document.getElementById('shiftEnd').value;

        // Convert the shift start and end times to Date objects
        var shiftStartDateTime = new Date(shiftDate + 'T' + startTime + ':00');
        var shiftEndDateTime = new Date(shiftDate + 'T' + endTime + ':00');
        var taskDeadlineDateTime = new Date(taskDeadline);
        // Validate if task deadline is within the shift time range
        if (!taskDeadline || taskDeadlineDateTime < shiftStartDateTime || taskDeadlineDateTime > shiftEndDateTime) {
            $('#taskDeadline1').addClass('is-invalid');
            $('#taskDeadline1Feedback').text('Deadline must be within the shift time range.').show();
            return false;
        } else if (isNaN(shiftStartDateTime) || isNaN(shiftEndDateTime)) {
            $('#taskDeadline1').addClass('is-invalid');
            $('#taskDeadline1Feedback').text('Deadline must be within the shift time range.').show();
        return false;
    } else {
            $('#taskDeadline1').removeClass('is-invalid');
            $('#taskDeadline1Feedback').hide();
            return true;
        }
    }

function addShift(role, roleId, dayIndex, rosterDate) {

    var textElement = document.getElementById('taskText');
    var iconElement = document.getElementById('chevronIcon');
    textElement.innerText = "Add more task";
    iconElement.classList.add('fa-chevron-down');
    shiftModal.show();

        // Initially hide the shift content and show the tasks content
    document.getElementById('shiftContent').style.display = 'block';
    document.getElementById('tasksContent').style.display = 'none';
    var rosterStart = new Date(rosterDate); // Convert roster start date string to a Date object
    var rosterStartDayIndex = rosterStart.getDay(); // Get day index of the roster start date (0 for Sunday, 1 for Monday, ..., 6 for Saturday)
    // Adjust dayIndex to match JavaScript's day indexing (1 for Monday, ..., 6 for Saturday, 0 for Sunday)
    var adjustedDayIndex = dayIndex - (rosterStartDayIndex === 0 ? -6 : rosterStartDayIndex - 1);

    // Make sure adjustedDayIndex is within the range of 0-6
    if (adjustedDayIndex < 0) {
        adjustedDayIndex += 7;
    }

    var shiftDate = new Date(rosterStart);
    shiftDate.setDate(rosterStart.getDate() + adjustedDayIndex);
    var options = { day: 'numeric', month: 'numeric', year: 'numeric', weekday: 'long' };
    var formattedDate = shiftDate.toLocaleDateString('en-GB', options); // Formats the date as "dd/mm/yyyy, Day"

    // Rest of your function...
    document.getElementById('roleId').value = roleId; // Sets the hidden role ID
    document.getElementById('roleName').textContent = role; // Displays the role name
    document.getElementById('shiftDate').textContent = formattedDate.replace(',', ''); // Removes the comma
    document.getElementById('hiddenDate').value = shiftDate.toISOString().split('T')[0];

    // Show the modal

    var s = '<label for="user_id">Employee <span style="color: red;">*</span></label><select class="form-control" name="user_id" id="user_id">';

    var t = '';

    var ava = <?php echo json_encode($userAvailabilities) ?>;
    var usersArr = <?php echo json_encode($usersArr) ?>;

    var dateMap = {
        0: 'monday',
        1: 'tuesday',
        2: 'wednesday',
        3: 'thursday',
        4: 'friday',
        5: 'saturday',
        6: 'sunday',
    };
    var date_key = dateMap[dayIndex]
    $.each(usersArr, function (kk,vv) {
        if (vv.isAdmin == 0) {
            $.each(ava,function (k,v) {
                if (v.user_id == vv.id) {
                    if (v[date_key]) {
                        t += `<option value="${ vv.id }">${ vv.logic_name }</option>`
                        return false
                    }
                }

            })
        }

    })

    s += t;
    s += '</select>'

    $('#user_ava').empty().html(s)
    // Now deadline should be '2023-06-20 04:41:00'
    document.getElementById('submitAll').addEventListener('click', function(event) {
    event.preventDefault(); // Prevent the form from submitting traditionally

    if(validateTimeRange() || (editvalidateTaskDescription() && editvalidateTaskDeadline() && validateTimeRange)){
        var shiftData = {
        roster_id: '<?= $roster->id ?>',
        shiftDate: document.getElementById('hiddenDate').value,
        role_id: document.getElementById('roleId').value,
        start_time:  document.getElementById('shiftStart').value,
        end_time: document.getElementById('shiftEnd').value,
        user_id: document.getElementById('user_id').value
    };
    var tasksData = {
        description: document.getElementById('taskDescription1').value,
        responsibility: document.getElementById('taskResponsibility').value,
        status: document.getElementById('taskStatus1').value,
        deadline: document.getElementById('taskDeadline1').value
    };
    // AJAX to submit the shift data
    $.ajax({
    type: 'GET',
    url: '<?= $this->Url->build(['controller' => 'Shifts', 'action' => 'add', $roster->id]) ?>',
    data: { data: shiftData },
    success: function (response) {
        if (response.status === 'error') {
    localStorage.setItem('toastMessage', response.message); // Store error message
    localStorage.setItem('status', 'error'); // Store status
} else if (response.status === 'success') {
    localStorage.setItem('toastMessage', response.message); // Store success message
    localStorage.setItem('status', 'success'); // Store status
    if (tasksData['description'] && editvalidateTaskDescription() && editvalidateTaskDeadline()) {
        submitTaskData(response.shiftId); // Function to submit task data
    } else {
        shiftModal.hide();
        setTimeout(function () {
            localStorage.setItem('showToast', 'true'); // Set flag in local storage
            window.location.reload();
        }, 500);
    }
}

        // Ensure the toast will show even if tasksData['description'] is true
        localStorage.setItem('showToast', 'true');
        window.location.reload();
    },
    error: function (xhr, status, error) {
        localStorage.setItem('toastMessage', 'An error occurred: ' + error); // Store AJAX error message
        localStorage.setItem('showToast', 'true'); // Set flag in local storage
        window.location.reload();
    }
});

    }
});

function submitTaskData(shiftId) {
    var tasksData = {
        description: document.getElementById('taskDescription1').value,
        responsibility: document.getElementById('taskResponsibility').value,
        status: document.getElementById('taskStatus1').value,
        deadline: document.getElementById('taskDeadline1').value,
        shift_id:shiftId
    };
    console.log(tasksData);
    $.ajax({
        type: 'GET',
        url: '<?= $this->Url->build(['controller' => 'Tasks', 'action' => 'add']) ?>',
        data: { data: tasksData },

        beforeSend: function(xhr) {
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        },
        success: function (exists) {
            localStorage.setItem('status', response.status);
            shiftModal.hide()
            setTimeout(function() {
            window.location.reload();
            }, 500); // Adjust the timeout duration as needed
        },
        error: function(xhr, status, error) {
            // console.error("Task submission error: " + error);
        }
    });
}

document.getElementById('closeAllModalClose').addEventListener('click', function () {
    // alert('c');
    shiftModal.hide();
    });
document.getElementById('closeAllModal').addEventListener('click', function () {
    // alert('d');
    shiftModal.hide();
    });

}



function deleteShift() {
    var shiftId = document.getElementById('modalShiftId').value;
    var formAction = '<?= $this->Url->build(['controller' => 'shifts', 'action' => 'delete', '__ID__']) ?>';
    formAction = formAction.replace('__ID__', shiftId);

    var form = document.createElement('form');
    form.setAttribute('method', 'post');
    form.setAttribute('action', formAction);

    // Add CSRF token field
    var csrfToken = document.querySelector('meta[name="csrfToken"]').getAttribute('content'); // Adjust this selector to match your page's layout
    var csrfField = document.createElement('input');
    csrfField.setAttribute('type', 'hidden');
    csrfField.setAttribute('name', '_csrfToken');
    csrfField.setAttribute('value', csrfToken);
    form.appendChild(csrfField);

    document.body.appendChild(form);
    form.submit();
}
function deletetask() {
    var taskId = document.getElementById('modalTaskId').value;
    var formAction = '<?= $this->Url->build(['controller' => 'tasks', 'action' => 'delete', '__ID__']) ?>';
    formAction = formAction.replace('__ID__', taskId);

    var form = document.createElement('form');
    form.setAttribute('method', 'post');
    form.setAttribute('action', formAction);

    // Add CSRF token field
    var csrfToken = document.querySelector('meta[name="csrfToken"]').getAttribute('content'); // Adjust this selector to match your page's layout
    var csrfField = document.createElement('input');
    csrfField.setAttribute('type', 'hidden');
    csrfField.setAttribute('name', '_csrfToken');
    csrfField.setAttribute('value', csrfToken);
    form.appendChild(csrfField);

    document.body.appendChild(form);
    form.submit();
}

function convertDatetime12(input){
    var deadlineDate = new Date(input);
                    // Format the date and time to YYYY-MM-DDTHH:mm for datetime-local input
                    var formattedDate = deadlineDate.getFullYear() + '-' +
                                        (deadlineDate.getMonth() + 1).toString().padStart(2, '0') + '-' +
                                        deadlineDate.getDate().toString().padStart(2, '0');
                    var formattedTime = deadlineDate.getHours().toString().padStart(2, '0') + ':' +
                                        deadlineDate.getMinutes().toString().padStart(2, '0');
                    var datetimeLocal = formattedDate + 'T' + formattedTime;
                    // Update HTML element with formatted datetime-local string
    return datetimeLocal;
}

var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
  return new bootstrap.Popover(popoverTriggerEl)
})
</script>
