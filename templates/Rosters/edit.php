<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Roster $roster
 */
?>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />



    <div class="">
        <nav class="bg-light d-flex justify-content-between align-items-center">
            <div class="ml-5 mr-3">
                <h3 class='text-primary'><?= __('Roster & Shift Management') ?></h3>
                <ol class="breadcrumb" style="margin: 0;">
                    <li class="breadcrumb-item text-decoration-none"><a href="<?= $this->Url->buildFromPath('Pages::index') ?>" class='text-decoration-none text-info'>Dashboard</a></li>
                    <?= $this->Html->link(__('Rosters'), ['action' => 'index'], ['class' => 'breadcrumb-item active text-decoration-none']) ?>
                    <?= $this->Html->link($roster->name, ['action' => 'edit',$roster->id], ['class' => 'breadcrumb-item active text-decoration-none']) ?>
                </ol>
            </div>
            <div>
                <a href="<?= $this->Url->build(['action' => 'index']) ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                    <i class="fas fa-list fa-sm text-white-50"></i> View All Rosters</a>
                <a href="<?= $this->Url->build(['action' => 'add']) ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                    <i class="fas fa-plus fa-sm text-white-50"></i> New Roster</a>
            </div>
        </nav>
        <div class="position-absolute top-0 end-0 p-2">
            <?= $this->Flash->render() ?>
        </div>
    </div>
    <br>
    <br>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <!-- <h4 class="card-title"><?= __('Edit Roster: ') , h($roster->roster_date->format('d/m/Y'))?></h4> -->
                            <h4 class="card-title"><?= __('Edit Roster: ') , h($roster->name)?></h4>
                            <h6 class="card-title"><?= h($roster->roster_date->format('d/m/Y')) . ' to ' . h($roster->end_date->format('d/m/Y')) ?></h6>
                            <div class="button-group">
                            <?= $this->Html->link('<i class="fa fa-arrow-left"></i> ' . __('Back'), ['action' => 'index'], ['class' => 'btn btn-secondary btn-sm', 'escape' => false]) ?>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                    <div class="row justify-content-center ">
                    <div class="input-group col-md-6">
                        <div class="input-group-prepend">
                            <button onclick="goToPreviousWeek()" class="btn btn-outline-secondary" type="button" id="previousWeek"data-bs-toggle="tooltip" data-bs-title="Previous Week"><i class="fa-solid fa-left-long"></i></button>
                        </div>
                        <span onclick="goToCurrentWeek('<?= $roster->roster_date->i18nFormat('yyyy-MM-dd') ?>')"  class="form-control text-center" id="dateRange" aria-label="Date range" data-bs-toggle="tooltip" data-bs-title="Click to current week">
                        <?= $roster->roster_date->i18nFormat('d MMM') ?> - <?= $roster->end_date->i18nFormat('d MMM') ?></span>
                        <div class="input-group-append">
                            <button onclick="goToNextWeek()" class="btn btn-outline-secondary" type="button" id="nextWeek"data-bs-toggle="tooltip" data-bs-title="Next Week"><i class="fa-solid fa-right-long"></i></button>
                        </div>
                    </div>

                </div>
                    <div class="card-body">
                        <!-- <?= $this->Form->create($roster) ?>
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <?= $this->Form->control('roster_date', ['class' => 'form-control', 'label' => ['text' => 'New Roster Date'], 'style' => 'width: 100%;']) ?>
                                </div>
                                <div class="form-group">
                                    <?= $this->Form->control('end_date', ['class' => 'form-control', 'label' => ['text' => 'New Roster Date'], 'style' => 'width: 100%;']) ?>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <?= $this->Form->button(__('Update'), ['class' => 'btn btn-success btn-block']) ?>
                            </div>
                        </div>
                        <?= $this->Form->end() ?> -->
                        <?= $this->Form->create($roster) ?>
                    <div class="row justify-content-center mt-3">
                        <div class="col-md-6">
                        <div class="form-group">
                            <?= $this->Form->control('name', [
                                'class' => 'form-control',
                                'label' => [
                                    'text' => 'Name <span style="color: red;">*</span>', 
                                    'escape' => false
                                ],
                                'style' => 'width: 100%;'
                            ]) ?>
                        </div>

                            <!-- backend -->
                            <div class="form-group">
                            <?= $this->Form->control('roster_date', [
                                    'class' => 'form-control',
                                    'style' => 'width: 100%;',
                                    'label' => false,
                                    'hidden' => true,
                                    'id' => 'rosterDatehidden', // Add this line
                                    'type' => 'text', // Ensure the type is set to text
                                    'readonly' => true, // Optional: make it readonly if you do not want the user to manually edit it
                                ]) ?>
                                                                <!-- show to fontend -->
                                <?= $this->Form->control('start', [
                                    'class' => 'form-control',
                                    'style' => 'width: 100%;',
                                    'label' => ['text' => 'Roster Date <span style="color: red;">*</span>', 'escape' => false],
                                    'id' => 'rosterDate', // Add this line
                                    'type' => 'text', // Ensure the type is set to text
                                    'readonly' => true, // Optional: make it readonly if you do not want the user to manually edit it
                                ]) ?>
                            </div>
                                <!-- send to backend -->
                                <?= $this->Form->control('end_date', [
                                    'class' => 'form-control',
                                    'label' => false,
                                    'hidden' => true,
                                    'style' => 'width: 100%;',
                                    'id' => 'end_datehidden', // Add this line
                                    'type' => 'text', // Ensure the type is set to text
                                    'readonly' => true, // Optional: make it readonly if you do not want the user to manually edit it
                                ]) ?>
                                <!-- show to front end -->
                                <?= $this->Form->control('end', [
                                    'class' => 'form-control',
                                    'label' => ['text' => 'End Date <span style="color: red;">*</span>', 'escape' => false],
                                    'style' => 'width: 100%;',
                                    'id' => 'end_date', // Add this line
                                    'type' => 'text', // Ensure the type is set to text
                                    'readonly' => true, // Optional: make it readonly if you do not want the user to manually edit it
                                ]) ?>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-6">

                            <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-outline-info btn-block']) ?>
                        </div>
                    </div>
                    <?= $this->Form->end() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const rosterDateInput = document.querySelector('#roster-date');

    rosterDateInput.addEventListener('change', () => {
        const selectedDate = new Date(rosterDateInput.value);
        const currentDate = new Date();
        currentDate.setHours(0, 0, 0, 0); // Set hours to midnight to compare dates

        if (selectedDate < currentDate) {
            alert('Roster date cannot be a past date');
            rosterDateInput.value = ''; // Clear the input value
        }
    });
});
</script>
<script>
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    var initialDate = "<?= $roster->roster_date->i18nFormat('yyyy-MM-dd') ?>"; // Retrieves the date from PHP in YYYY-MM-DD format
    var currentDate = new Date(initialDate); // Initialize the JavaScript Date object with this date


function getMonday(d) {
    d = new Date(d);
    var day = d.getDay(),
        diff = d.getDate() - day + (day == 0 ? -6 : 1); // adjust when day is Sunday
    return new Date(d.setDate(diff));
}

function updateDateDisplay(date) {
    var monday = getMonday(date);
    var sunday = new Date(monday.getTime());
    sunday.setDate(monday.getDate() + 6);

    var startDateFormatted = formatDate(monday);
    var endDateFormatted = formatDate(sunday);
    document.getElementById('dateRange').textContent = formatDateRangeDisplay(monday) + ' - ' + formatDateRangeDisplay(sunday);
    console.log(date);
    console.log(startDateFormatted);
    console.log( document.getElementById('dateRange').textContent);
    // Set the value of the form control to the start date of the week
    document.getElementById('rosterDate').value = swapdateformat(startDateFormatted);
    document.getElementById('rosterDatehidden').value = startDateFormatted
    document.getElementById('end_datehidden').value = endDateFormatted;
    document.getElementById('end_date').value = swapdateformat(endDateFormatted);
}
function swapdateformat(date){

var oldDate = date;
var parts = oldDate.split("-");
var newDate = parts[2] + "-" + parts[1] + "-" + parts[0];
return newDate;
}

function formatDateRangeDisplay(d) {
    let day = d.getDate();
    let month = d.toLocaleString('en-US', { month: 'short' }); // 'short' gives the abbreviated month name
    return `${day} ${month}`;
}
function formatDate(d) {
    return d.toISOString().substring(0, 10); // format YYYY-MM-DD
}

function goToPreviousWeek() {
    currentDate.setDate(currentDate.getDate() - 7);
    updateDateDisplay(currentDate);
}

function goToNextWeek() {
    currentDate.setDate(currentDate.getDate() + 7);
    updateDateDisplay(currentDate);
}

function goToCurrentWeek(rosterStart) {
    currentDate = new Date(rosterStart); // reset to current date
    updateDateDisplay(currentDate);
}

window.onload = function() {
    updateDateDisplay(currentDate);
};
</script>
