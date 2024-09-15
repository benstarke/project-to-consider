<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Roster $roster
 */
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/datepicker/1.0.10/datepicker.min.css">
<div class="rosters index content">
    <div class="">
        <nav class="bg-light d-flex justify-content-between align-items-center">
            <div class="ml-5 mr-3">
                <h3 class='text-primary'><?= __('Roster & Shift Management') ?></h3>
                <ol class="breadcrumb" style="margin: 0;">
                    <li class="breadcrumb-item text-decoration-none"><a href="<?= $this->Url->buildFromPath('Pages::index') ?>" class='text-decoration-none text-info'>Dashboard</a></li>
                    <?= $this->Html->link(__('Rosters'), ['action' => 'index'], ['class' => 'breadcrumb-item active text-decoration-none']) ?>
                </ol>
            </div>
            <div>
                <a href="<?= $this->Url->build(['action' => 'index']) ?>" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
                    <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Rosters </a>
            </div>
        </nav>
    </div>
    <div class="position-absolute top-0 end-0 p-2">
        <?= $this->Flash->render() ?>
</div>
</div>

<br>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"><?= __('Add Roster') ?></h4>
                </div>
                <div class="card-body">
                    <div class="row justify-content-center ">
                    <div class="input-group col-md-6">
                        <div class="input-group-prepend">
                            <button onclick="goToPreviousWeek()" class="btn btn-outline-secondary" type="button" id="previousWeek"  data-bs-toggle="tooltip" data-bs-title="Previous Week"><i class="fa-solid fa-left-long"></i></button>
                        </div>
                        <span onclick="goToCurrentWeek()"  class="form-control text-center" id="dateRange" aria-label="Date range" data-bs-toggle="tooltip" data-bs-title="Click to current week"></span>
                        <div class="input-group-append">
                            <button onclick="goToNextWeek()" class="btn btn-outline-secondary" type="button" id="nextWeek" data-bs-toggle="tooltip" data-bs-title="Next Week"><i class="fa-solid fa-right-long"></i></button>
                        </div>
                    </div>

                </div>
                    <?= $this->Form->create($roster) ?>
                    <div class="row justify-content-center mt-3">
                        <div class="col-md-6">
                        <div class="form-group">
                        <?= $this->Form->control('name', [
                            'id' => 'nameInput',
                            'class' => 'form-control',
                            'label' => ['text' => 'Name <span style="color: red;">*</span>', 'escape' => false],
                            'style' => 'width: 100%;',
                        ]) ?>

                            <span id="nameError" style="color: red; display: none;"></span>
                        </div>

                            <div class="form-group">
                                <!-- pass to backend -->
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
                                    'label' => ['text' => 'Start Date <span style="color: red;">*</span>', 'escape' => false],
                                    'id' => 'rosterDate', // Add this line
                                    'type' => 'text', // Ensure the type is set to text
                                    'readonly' => true, // Optional: make it readonly if you do not want the user to manually edit it
                                ]) ?>
                            </div>

                            <div class="form-group">
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

                            <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-outline-info btn-block', 'onClick' => 'return validateAddForm();']) ?>
                        </div>
                    </div>
                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
var currentDate = new Date();

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

    console.log('Current Date ' +date);
console.log('Monday ' + monday);
console.log('Sunday ' + sunday);

    var startDateFormatted = formatDate(monday);
    var endDateFormatted = formatDate(sunday);
    document.getElementById('dateRange').textContent = formatDateRangeDisplay(monday) + ' - ' + formatDateRangeDisplay(sunday);

    console.log(startDateFormatted);
    console.log(endDateFormatted);


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
function formatDate(d) {
    return `${d.getFullYear()}-${('0' + (d.getMonth() + 1)).slice(-2)}-${('0' + d.getDate()).slice(-2)}`;
}


function formatDateRangeDisplay(d) {
    let day = d.getDate();
    let month = d.toLocaleString('en-US', { month: 'short' }); // 'short' gives the abbreviated month name
    return `${day} ${month}`;
}


function goToPreviousWeek() {
    currentDate.setDate(currentDate.getDate() - 7);
    updateDateDisplay(currentDate);
}

function goToNextWeek() {
    currentDate.setDate(currentDate.getDate() + 7);
    updateDateDisplay(currentDate);
}

function goToCurrentWeek() {
    currentDate = new Date(); // reset to current date
    updateDateDisplay(currentDate);
}

window.onload = function() {
    updateDateDisplay(currentDate);
};


function validateAddForm() {
    var result = true;
    var nameInput = document.getElementById('nameInput');
    var nameError = document.getElementById('nameError');
    var nameValue = nameInput.value.trim();
    var nameRegex = /^[a-zA-Z0-9\s]*$/; // Allows alphabets, digits, and whitespace

    if (nameValue.length === 0) {
        nameInput.style.borderColor = 'red';
        nameError.textContent = 'Name cannot be empty';
        nameError.style.display = 'block';
        result = false;
    } else if (!nameRegex.test(nameValue)) {
        nameInput.style.borderColor = 'red';
        nameError.textContent = 'Name should only contain alphabets and digits.';
        nameError.style.display = 'block';
        result = false;
    } else {
        nameInput.style.borderColor = 'initial';
        nameError.style.display = 'none';

    }
    return result;
}

</script>
