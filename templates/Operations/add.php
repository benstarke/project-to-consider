<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Operation $operation
 */
?>


<div class="rosters index content">
    <div class="">
        <nav class="bg-light d-flex justify-content-between align-items-center">
            <div class="ml-5 mr-3">
                <h3 class='text-primary'><?= __('Business Hours') ?></h3>
                <ol class="breadcrumb" style="margin: 0;">
                    <li class="breadcrumb-item text-decoration-none"><a href="<?= $this->Url->buildFromPath('Pages::index') ?>" class='text-decoration-none text-info'>Dashboard</a></li>
                    <?= $this->Html->link(__('Operations'), ['controller' => 'Operations', 'action' => 'index'], ['class' => 'breadcrumb-item active text-decoration-none']) ?>
                </ol>
            </div>
        </nav>
        <div class="position-absolute top-0 end-0 p-2">
            <?= $this->Flash->render() ?>
        </div>
    </div>
</div>

<br>
<div class="container mt-1 mb-5">
    <div class="card h5">
        <div class="card-header h4">
            Business Hours
        </div>
        <?= $this->Form->create($operations, ['url' => ['controller' => 'Operations','action' => 'edit']]) ?>
        <?php foreach ($operations as $op) : ?>
        <div class="card-body " style="background-color:transparent;">
            <?php
// Check if start time is null or empty and handle accordingly
            $timeValueStart = null;
            $formattedStartTime = '';
            if (!empty($op->day_start)) {
                $timeValueStart = DateTime::createFromFormat('h:i A', $op->day_start);
                $formattedStartTime = $timeValueStart ? $timeValueStart->format('H:i') : '';
            }

// Check if end time is null or empty and handle accordingly
            $timeValueEnd = null;
            $formattedEndTime = '';
            if (!empty($op->day_end)) {
                $timeValueEnd = DateTime::createFromFormat('h:i A', $op->day_end);
                $formattedEndTime = $timeValueEnd ? $timeValueEnd->format('H:i') : '';
            }
            ?>

            <fieldset class="row mb-1">
                <div class="col-form-label col-sm-2 pt-0" style="display: flex; align-items: center;">
                    <legend style="margin-right: auto;"><?= h($op->day_name) ?></legend>
                    <div class="form-check form-switch">
                        <input type="hidden" name="<?= h($op->day_name) ?>[isActive]" value="0">
                        <input type="checkbox" name="<?= h($op->day_name) ?>[isActive]" class="form-check-input" value="1" <?= $op->isActive ? 'checked' : '' ?> onchange="toggleTimeInputs(this, '<?= h($op->day_name) ?>')">
                    </div>
                </div>
                <div class="col-sm-10">
                    <div class="input-group" id="<?= h($op->day_name) ?>InputGroup">
                        <input type="time" name="<?= h($op->day_name) ?>[day_start]" class="form-control" id="<?= h($op->day_name) ?>Start" step="900" value="<?= $formattedStartTime ?>">
                        <span class="input-group-text">to</span>
                        <input type="time" name="<?= h($op->day_name) ?>[day_end]" class="form-control" id="<?= h($op->day_name) ?>End" step="900" value="<?= $formattedEndTime ?>">
                    </div>
                    <div id="<?= h($op->day_name) ?>Error" style="display: none; color:red">End time must be after start time.</div>
                </div>
            </fieldset>
        </div>
        <?php endforeach; ?>
          <div class="row mb-1">
            <div class="col-sm-10 offset-sm-2 ">
            <?= $this->Html->link('<i class="fa-solid fa-rotate" style="color: #ffffff; margin-right: 5px;"></i>' . __('Reset'), ['controller' => 'Operations', 'action' => 'add'], ['class' => 'btn btn-secondary', 'escape' => false]) ?>
              <!-- <button type="button" class="btn btn-info"><span class="cil-contrast"></span> Info</button> -->
                <?= $this->Form->button(__('Update'), ['class' => 'btn btn-outline-info', 'onClick' => 'return onSubmitClick();']) ?>
                <!-- <?= $this->Form->button(__('Update'), ['controller' => 'Operations' ,'action' => 'edit','class' => 'btn btn-outline-info']) ?> -->
                <?= $this->Form->end() ?>
            </div>
          </div>
    </div>
</div>


  <script>
    var result =true;
    function validateTime(startId, endId, errorId) {
        const startTime = document.getElementById(startId).value;
        const endTime = document.getElementById(endId).value;
        const errorText = document.getElementById(errorId);
        const inputGroup = errorText.previousElementSibling;

        if (startTime >= endTime) {
            // Show error and add red border if start time is not before end time
            inputGroup.classList.add('border', 'border-danger');

            errorText.style.display = 'block';
            result =false;

        } else {
            // Hide error and remove red border if time is valid
            inputGroup.classList.remove('border', 'border-danger');
            errorText.style.display = 'none';
            result =true;
        }
    }
document.addEventListener("DOMContentLoaded", function() {
  // Function to validate time


  // Event listeners for time change
  document.getElementById("MondayStart").addEventListener("change", function() {
    validateTime("MondayStart", "MondayEnd", "MondayError");
  });

  document.getElementById("MondayEnd").addEventListener("change", function() {
    validateTime("MondayStart", "MondayEnd", "MondayError");
  });
  document.getElementById("TuesdayStart").addEventListener("change", function() {
    validateTime("TuesdayStart", "TuesdayEnd", "TuesdayError");
});

document.getElementById("TuesdayEnd").addEventListener("change", function() {
    validateTime("TuesdayStart", "TuesdayEnd", "TuesdayError");
});

document.getElementById("WednesdayStart").addEventListener("change", function() {
    validateTime("WednesdayStart", "WednesdayEnd", "WednesdayError");
});

document.getElementById("WednesdayEnd").addEventListener("change", function() {
    validateTime("WednesdayStart", "WednesdayEnd", "WednesdayError");
});
document.getElementById("ThursdayStart").addEventListener("change", function() {
    validateTime("ThursdayStart", "ThursdayEnd", "ThursdayError");
});

document.getElementById("ThursdayEnd").addEventListener("change", function() {
    validateTime("ThursdayStart", "ThursdayEnd", "ThursdayError");
});
document.getElementById("FridayStart").addEventListener("change", function() {
    validateTime("FridayStart", "FridayEnd", "FridayError");
});

document.getElementById("FridayEnd").addEventListener("change", function() {
    validateTime("FridayStart", "FridayEnd", "FridayError");
});

document.getElementById("SaturdayStart").addEventListener("change", function() {
    validateTime("SaturdayStart", "SaturdayEnd", "SaturdayError");
});

document.getElementById("SaturdayEnd").addEventListener("change", function() {
    validateTime("SaturdayStart", "SaturdayEnd", "SaturdayError");
});
document.getElementById("SundayStart").addEventListener("change", function() {
    validateTime("SundayStart", "SundayEnd", "SundayError");
});

document.getElementById("SundayEnd").addEventListener("change", function() {
    validateTime("SundayStart", "SundayEnd", "SundayError");
});
});
function onSubmitClick() {
    if (!result) {
      return result;
    }
  }

</script>
<script>
function toggleTimeInputs(checkbox, dayName) {
    const startTimeInput = document.getElementById(dayName + 'Start');
    const endTimeInput = document.getElementById(dayName + 'End');
    const errorDiv = document.getElementById(dayName + 'Error');
    const inputGroup = errorDiv.previousElementSibling;
    console.log(checkbox.checked);

        if (checkbox.checked) { //uncheck
            validateTime(dayName+"Start", dayName+"End", dayName+"Error");
        // Checkbox is unchecked: enable inputs
        startTimeInput.disabled = false;
        endTimeInput.disabled = false;

        //inputGroup.classList.add('border', 'border-danger');

        //errorDiv.style.display = 'block';

        //result = false;
    } else { //check
        // Checkbox is checked: disable inputs and clear their values
       // startTimeInput.value = '';
       // endTimeInput.value = '';
        //inputGroup.classList.remove('border', 'border-danger');
       // errorDiv.style.display = 'none';
        //startTimeInput.disabled = true;
        //endTimeInput.disabled = true;
        //result = !checkbox.checked;
            inputGroup.classList.remove('border', 'border-danger');

            errorDiv.style.display = 'none';

            result = true;
    }


}

</script>
