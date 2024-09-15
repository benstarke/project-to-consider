<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>

<main>
<div class="position-relative">
    <nav class="bg-light d-flex justify-content-between align-items-center">
        <div class="ml-5 mr-3">
            <h3 class='text-primary'><?= __('Account Management') ?></h3>
            <ol class="breadcrumb" style="margin: 0;">
                <li class="breadcrumb-item text-decoration-none"><a href="<?= $this->Url->buildFromPath('Pages::index') ?>" class='text-decoration-none text-info'>Dashboard</a></li>

                <!-- Only admins and managers should see employees page -->
                <?php if (($this->Identity->get('isAdmin') == 1) || ($this->Identity->get('isManager') == 1)): ?>
                    <?= $this->Html->link(__('Employees'), ['action' => 'index'], ['class' => 'breadcrumb-item text-decoration-none  text-info']) ?>
                <?php endif ?>

                <li class="breadcrumb-item text-decoration-none active"><?= $user->f_name ?> <?= $user->l_name ?></li>
            </ol>

        </div>
        <?php if (($this->Identity->get('isAdmin') == 1) || ($this->Identity->get('isManager') == 1)): ?>
            <a href="#" onclick="history.go(-1);" class="btn btn-sm btn-secondary shadow-sm">
                <i class="fa fa-arrow-left"></i>Back
            </a>
        <?php endif ?>
    </nav>
    <div class="position-absolute top-0 end-0 p-2">
        <?= $this->Flash->render() ?>
    </div>
</div>
<div class="container-xl px-4 mt-4">
    <h1 class='text-primary'>Edit Profile - <?= $user->f_name ?> <?= $user->l_name ?></h1>
    <div class="row text-info">
        <div class="col-xl-4">

            <!-- Profile picture card-->
            <div class="card mb-4 mb-xl-0">
                <div class="card-header">Profile Picture</div>
                <?= $this->Form->create($user, ['type' => 'file']) ?>
                <div class="card-body text-center">

                    <!-- Profile picture image-->
                    <img class="img-account-profile rounded-circle mb-2" src="<?= $this->Url->build($user->avatarimg) ?>" style="width: 200px; height: 200px; object-fit: cover;" alt="User Profile Image">
                    <!-- Profile picture help block-->
                    <div class="small font-italic text-muted mb-4">JPG or PNG no larger than 5 MB</div>
                    <!-- Profile picture upload button-->
                    <?php echo $this->Form->control('avatarimg', ['type' => 'file','accept' => 'image/*','required' => false ,'label' => false, 'class' => 'form-control']); ?>
                </div>
            </div>
        </div>
        <div class=" col-xl-8">
        <ul class="nav nav-tabs " id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active text-info" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Account Details</a>
            </li>

            <!-- only managers and employees have availability -->
            <?php if (($this->Identity->get('isAdmin') == 0)): ?>
                <li class="nav-item">
                    <a class="nav-link text-primary" id="availability-tab" data-toggle="tab" href="#availability" role="tab" aria-controls="availability" aria-selected="false">Availability</a>
                </li>
            <?php endif ?>

            <li class="nav-item">
                <a class="nav-link text-primary" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Security & Privacy</a>
            </li>
        </ul>
        <div class="tab-content card-body card" id="myTabContent">
            <div class="tab-pane fade show active  " id="home" role="tabpanel" aria-labelledby="home-tab">
                <!-- Form Row-->
                <div class="row gx-3 mb-3">

                    <!-- Form Group (first name)-->
                    <div class="col-md-6">
                        <label class="small mb-1" for="inputFirstName">First name <span style="color: red;">*</span></label>
                        <?= $this->Form->control('f_name', [
                            'class' => 'form-control',
                            'type' => 'text', 'label' => false,
                            'maxLength' => 55,
                            'id' => 'firstNameInput', // Ensure you have this ID attribute
                        ]) ?>
                    <span id="firstNameError" style="color: red; display: none;">First name should not contain special characters.</span>
                    </div>

                    <!-- Form Group (last name)-->
                    <div class="col-md-6">
                        <label class="small mb-1" for="inputLastName">Last name <span style="color: red;">*</span></label>
                        <?= $this->Form->control('l_name', [
                        'class' => 'form-control',
                        'type' => 'text',
                        'label' => false,
                        'maxLength' => 55,
                        'id' => 'lastNameInput', // Added ID attribute for JavaScript access
                    ]) ?>
                    <span id="lastNameError" style="color: red; display: none;">Last name should not contain special characters.</span>
                    </div>
                </div>

                <!-- Form Row -->
                <div class="row gx-3 mb-3">

                    <!-- Form Group (Gender)-->
                    <div class="col-md-6">
                        <label for="small mb-1">Gender</label>
                        <?php echo $this->Form->control('gender', [
                            'label' => false,
                            'options' => [
                                '' => '', // Empty value
                                1 => 'Male',
                                2 => 'Female',
                                3 => 'Non-Binary',
                                4 => 'Agender/I don’t identify with any gender',
                                5 => 'Prefer not to say',
                            ],
                            'class' => 'form-control',
                            'default' => '', // Set default value to empty
                            'id' => 'gender',
                        ]); ?>
                        <span id="genderError" style="color: red; display: none;">Please select a gender.</span>
                    </div>
                    <div class="col-md-6">
                        <label for="small mb-1">Birthday</label>
                        <?= $this->Form->control('birthday', [
                            'class' => 'form-control',
                            'type' => 'date',
                            'label' => false,
                            'id' => 'birthdayInput',
                        ]) ?>
                        <span id="birthdayError" style="color: red; display: none;">Please enter a valid date of birth.</span>
                    </div>
                </div>
                <!-- Form Row-->
                <div class="row gx-3 mb-3">

                    <!-- Form Group (phone number)-->
                    <div class="col-md-6">
                        <?= $this->Form->control('phone', [
                            'class' => 'form-control',
                            'label' => 'Phone Number',
                            'maxLength' => 10,
                            'minLength' => 10,
                            'id' => 'phoneInput',
                    ]) ?>
                    <span id="phoneError" style="color: red; display: none;">Please enter a valid phone number starting with 0 and followed by 9 digits.</span>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="small " for="inputEmailAddress">Email address <span style="color: red;">*</span></label>
                        <?= $this->Form->control('email', ['class' => 'form-control', 'type' => 'email', 'placeholder' => 'Enter your email address','label' => false, 'maxLength' => 255]) ?>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="small mb-1" for="inputEmailAddress">Home Address</label>
                    <?= $this->Form->control('address', ['class' => 'form-control', 'type' => 'text', 'placeholder' => 'Enter your address','label' => false, 'maxLength' => 255]) ?>
                </div>

                <!-- [EMPLOYEE, MANAGER, ADMIN] SELECT - ADMIN VIEW -->
                <?php if ($this->Identity->get('isAdmin') == 1): ?>
                    <div class="row">
                        <div class="form-floating mb-3 text-left" id="rolesContainer">
                            <?= $this->Form->control('role', [
                                'class' => 'form-select',
                                'label' => 'Role <span style="color: red;">*</span>',
                                'options' => [
                                    'isAdmin' => 'Admin',
                                    'isManager' => 'Manager',
                                    'isEmployee' => 'Employee'
                                ],
                                'empty' => 'Select Role',
                                'id' => 'roleSelect',
                                'value' => ($user['isAdmin'] == 1) ? 'isAdmin' : (($user['isManager'] == 1) ? 'isManager' : 'isEmployee'),
                                'escape' => false,
                            ]) ?>
                            <span id="rolesError" style="color: red; display: none;">Please select a role.</span>
                        </div>
                    </div>

                    <?= $this->Form->hidden('isAdmin', ['id' => 'isAdminInput']) ?>
                    <?= $this->Form->hidden('isManager', ['id' => 'isManagerInput']) ?>
                    <?= $this->Form->hidden('isEmployee', ['id' => 'isEmployeeInput']) ?>

                    <!-- [EMPLOYEE, MANAGER] SELECT - MANAGER VIEW -->
                <?php elseif ($this->Identity->get('isManager') == 1): ?>
                    <div class="row">
                        <div class="form-floating mb-3 text-left" id="rolesContainer">
                            <?= $this->Form->control('role', [
                                'class' => 'form-select',
                                'label' => 'Role',
                                'options' => [
                                    'isManager' => 'Manager',
                                    'isEmployee' => 'Employee'
                                ],
                                'empty' => 'Select Role',
                                'id' => 'roleSelect',
                                'value' => ($user['isAdmin'] == 1) ? 'isAdmin' : (($user['isManager'] == 1) ? 'isManager' : 'isEmployee'),

                            ]) ?>
                            <span id="rolesError" style="color: red; display: none;">Please select a role.</span>
                        </div>
                    </div>

                    <?= $this->Form->hidden('isAdmin', ['id' => 'isAdminInput']) ?>
                    <?= $this->Form->hidden('isManager', ['id' => 'isManagerInput']) ?>
                    <?= $this->Form->hidden('isEmployee', ['id' => 'isEmployeeInput']) ?>
                <?php endif; ?>


                <!-- Save changes button-->
                <?= $this->Form->button(__('Save Changes'),
                    [
                        'class' => 'btn btn-outline-info',
                        'onClick' => 'if(validateForm()) { if(confirm("Are you sure you want to save changes?")) { return true; } } return false;',

                    ]) ?>
                <?= $this->Form->end()?>
            </div>

            <div class="tab-pane fade" id="availability" role="tabpanel" aria-labelledby="availability-tab">
                <div class="row">
                    <div class="column column-80">
                        <div class="availabilities view content">
                            <table style="width: 100%; border-collapse: collapse;">
                                <tr style="background-color: #f2f2f2;">
                                    <th style="padding: 10px; border-bottom: 1px solid #ddd;"><?= __('Day') ?></th>
                                    <th style="padding: 10px; border-bottom: 1px solid #ddd;"><?= __('Availability to Work') ?></th>
                                </tr>
                                <tr>
                                    <td style="padding: 10px; border-bottom: 1px solid #ddd;"><?= __('Monday') ?></td>
                                    <td style="padding: 10px; border-bottom: 1px solid #ddd; <?= $personAvailable->monday ? 'color: green;' : 'color: red;' ?>">
                                        <?= $personAvailable->monday ? __('Available') : __('Unavailable') ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px; border-bottom: 1px solid #ddd;"><?= __('Tuesday') ?></td>
                                    <td style="padding: 10px; border-bottom: 1px solid #ddd; <?= $personAvailable->tuesday ? 'color: green;' : 'color: red;' ?>">
                                        <?= $personAvailable->tuesday ? __('Available') : __('Unavailable') ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px; border-bottom: 1px solid #ddd;"><?= __('Wednesday') ?></td>
                                    <td style="padding: 10px; border-bottom: 1px solid #ddd; <?= $personAvailable->wednesday ? 'color: green;' : 'color: red;' ?>">
                                        <?= $personAvailable->wednesday ? __('Available') : __('Unavailable') ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px; border-bottom: 1px solid #ddd;"><?= __('Thursday') ?></td>
                                    <td style="padding: 10px; border-bottom: 1px solid #ddd; <?= $personAvailable->thursday ? 'color: green;' : 'color: red;' ?>">
                                        <?= $personAvailable->thursday ? __('Available') : __('Unavailable') ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px; border-bottom: 1px solid #ddd;"><?= __('Friday') ?></td>
                                    <td style="padding: 10px; border-bottom: 1px solid #ddd; <?= $personAvailable->friday ? 'color: green;' : 'color: red;' ?>">
                                        <?= $personAvailable->friday ? __('Available') : __('Unavailable') ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px; border-bottom: 1px solid #ddd;"><?= __('Saturday') ?></td>
                                    <td style="padding: 10px; border-bottom: 1px solid #ddd; <?= $personAvailable->saturday ? 'color: green;' : 'color: red;' ?>">
                                        <?= $personAvailable->saturday ? __('Available') : __('Unavailable') ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 10px; border-bottom: 1px solid #ddd;"><?= __('Sunday') ?></td>
                                    <td style="padding: 10px; border-bottom: 1px solid #ddd; <?= $personAvailable->sunday ? 'color: green;' : 'color: red;' ?>">
                                        <?= $personAvailable->sunday ? __('Available') : __('Unavailable') ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <?php if ($this->Identity->get('isAdmin') == 0): ?>
                    <br>
                    <a href="<?= $this->Url->build(['controller' => 'Availabilities', 'action' => 'myavailabilities']) ?>" class="btn btn-outline-info">Edit Availability</a>
                <?php endif ?>

            </div>


            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
    <div class="card">
        <div class="card-body text-center">
            <p>If you want to reset your password, please click the button below:</p>
            <?= $this->Html->link('Forgot password?', ['controller' => 'Auth', 'action' => 'forgetPassword'], ['class' => 'btn btn-outline-info text-decoration-none']) ?>
        </div>
    </div>
</div>

                    <script>$(document).ready(function() {
                        $("#show_hide_password a").on('click', function(event) {
                            event.preventDefault();
                            if($('#show_hide_password input').attr("type") == "text"){
                                $('#show_hide_password input').attr('type', 'password');
                                $('#show_hide_password i').addClass( "fa-eye-slash" );
                                $('#show_hide_password i').removeClass( "fa-eye" );
                            }else if($('#show_hide_password input').attr("type") == "password"){
                                $('#show_hide_password input').attr('type', 'text');
                                $('#show_hide_password i').removeClass( "fa-eye-slash" );
                                $('#show_hide_password i').addClass( "fa-eye" );
                            }
                        });
                    });</script>
                    <div class="progress mt-3 fs-5 " id="strengthContainer" style='height :3%'>
                        <div class="progress-bar progress-bar-striped badge displayBadge"id="StrengthDisp" role="progressbar"></div>
                    </div>
                    <hr>
                
            </div>
        </div>
    </div>
</div>
<script>
      let timeout;

      // traversing the DOM and getting the input and span using their IDs

      let password = document.getElementById('password')
      let strengthBadge = document.getElementById('StrengthDisp')
      let strengthContainer = document.getElementById("strengthContainer");

      // The strong and weak password Regex pattern checker

      let strongPassword = new RegExp('(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{8,})')
      let mediumPassword = new RegExp('((?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{6,}))|((?=.*[a-z])(?=.*[A-Z])(?=.{8,}))')

      function StrengthChecker(PasswordParameter){
          // We then change the badge's color and text based on the password strength

          if(strongPassword.test(PasswordParameter)) {
              strengthBadge.style.backgroundColor = "green"
              strengthBadge.textContent = 'Strong'
              strengthBadge.class = 'bg-success'
              strengthBadge.style.width = '100%'

          } else if(mediumPassword.test(PasswordParameter)){
              strengthBadge.style.backgroundColor = '#FF8C00'
              strengthBadge.textContent = 'Medium'
              strengthBadge.class = 'bg-warning'
              strengthBadge.style.width = '60%'
          } else{
              strengthBadge.style.backgroundColor = 'red'
              strengthBadge.textContent = 'Weak'
              strengthBadge.class = 'bg-danger'
              strengthBadge.style.width = '35%'
          }
      }

      // Adding an input event listener when a user types to the  password input

      password.addEventListener("input", () => {

          //The badge is hidden by default, so we show it

          strengthBadge.style.display= 'block'
          clearTimeout(timeout);

          //We then call the StrengChecker function as a callback then pass the typed password to it

          timeout = setTimeout(() => StrengthChecker(password.value));

          //Incase a user clears the text, the badge is hidden again

          if(password.value.length !== 0){
              strengthBadge.style.display != 'block'
          } else{
              strengthBadge.style.display = 'none'
          }
      });
</script>
<script>
function validateForm() {
    var phoneInput = document.getElementById('phoneInput');
    var phoneValue = phoneInput.value;

    var phoneError = document.getElementById('phoneError');
    var result =true;
    // First, handle the case where the length is 9 and it doesn't start with '0'
    if (phoneValue.length === 9 && !phoneValue.startsWith('0')) {
        phoneInput.value = '0' + phoneValue;
        phoneValue = phoneInput.value;  // Update phoneValue to reflect the change
    }

    // Then, validate the phone number
    if (!/^0\d{9}$/.test(phoneValue)) {
        phoneInput.style.borderColor = 'red';
        phoneError.style.display = 'block';
        result = false;
    } else {
        phoneInput.style.borderColor = 'initial';
        phoneError.style.display = 'none';
    }

    //validation for DOB
    var DOBInput = document.getElementById('birthdayInput');
    var birthdayError = document.getElementById('birthdayError');
    var DOBValue = DOBInput.value;
    var currentDate = new Date();
    var minDOB = new Date(currentDate.getFullYear() - 100, currentDate.getMonth(), currentDate.getDate());
    var maxDOB = new Date(currentDate.getFullYear() - 12, currentDate.getMonth(), currentDate.getDate());
    var userDOB = new Date(DOBValue);

    if (userDOB < minDOB || userDOB > maxDOB) {
        // Invalid date of birth
        birthdayError.style.display = 'block';
        DOBInput.style.borderColor = 'red';
        result = false;
    } else {
        // Valid date of birth
        birthdayError.style.display = 'none';
        DOBInput.style.borderColor = 'initial';
    }


    // Role Validation
    const roleSelect = document.querySelector('#roleSelect');
    const rolesError = document.querySelector('#rolesError');

    if (roleSelect.value === '') {
        roleSelect.style.borderColor = 'red';
        rolesError.style.display = 'block'; // Display error message
        rolesError.style.display = 'block';
        result = false;

    } else {
        rolesContainer.style.borderColor = 'initial';
        rolesContainer.style.borderWidth = '0';
        rolesError.style.display = 'none';
    }

    // Validation for DOB


    //validation for first name
    var firstNameInput = document.getElementById('firstNameInput');
    var firstNameError = document.getElementById('firstNameError');
    var firstNameValue = firstNameInput.value;
    var nameRegex = /^[a-zA-Z\s]*$/; // Allows only letters and whitespace

    if (!nameRegex.test(firstNameValue)) {
        firstNameInput.style.borderColor = 'red'; // Show error for special characters
        firstNameError.style.display = 'block'; // Display error message
        result = false;
    } else {
        firstNameInput.style.borderColor = 'initial'; // Reset border color
        firstNameError.style.display = 'none'; // Hide error message
    }

    var lastNameInput = document.getElementById('lastNameInput');
    var lastNameError = document.getElementById('lastNameError');
    var lastNameValue = lastNameInput.value;

    if (!nameRegex.test(lastNameValue)) {
        lastNameInput.style.borderColor = 'red'; // Show error for special characters
        lastNameError.style.display = 'block'; // Display error message
        result = false;
    } else {
        lastNameInput.style.borderColor = 'initial'; // Reset border color
        lastNameError.style.display = 'none'; // Hide error message
    }

    return result;
}

document.addEventListener('DOMContentLoaded', function () {
    const roleSelect = document.getElementById('roleSelect');
    const isAdminInput = document.getElementById('isAdminInput');
    const isManagerInput = document.getElementById('isManagerInput');
    const isEmployeeInput = document.getElementById('isEmployeeInput');

    // event listener for select input change
    roleSelect.addEventListener('change', function () {
        const selectedRole = roleSelect.value;

        // set all values to 0 as default
        isAdminInput.value = 0;
        isManagerInput.value = 0;
        isEmployeeInput.value = 0;

        // role selected from drop-down set to 1
        if (selectedRole === 'isAdmin') {
            isAdminInput.value = 1;
        } else if (selectedRole === 'isManager') {
            isManagerInput.value = 1;
        } else if (selectedRole === 'isEmployee') {
            isEmployeeInput.value = 1;
        }
    });
});
</script>
<script>
    var phoneInput = document.getElementById('phoneInput');
var phoneError = document.getElementById('phoneError');

phoneInput.addEventListener('change', function() {
    var phoneValue = phoneInput.value.trim(); // Trim the input value
    var result = true; // Initialize result variable

    // First, handle the case where the length is 9 and it doesn't start with '0'
    if (phoneValue.length === 9 && !phoneValue.startsWith('0')) {
        phoneInput.value = '0' + phoneValue;
        phoneValue = phoneInput.value;  // Update phoneValue to reflect the change
    }

    // Then, validate the phone number
    if (!/^0\d{9}$/.test(phoneValue)) {
        phoneInput.style.borderColor = 'red';
        phoneError.style.display = 'block';
        result = false;
    } else {
        phoneInput.style.borderColor = 'initial';
        phoneError.style.display = 'none';
    }

    // Return result if needed for further processing
    return result;
});
var DOBInput = document.getElementById('birthdayInput');
var birthdayError = document.getElementById('birthdayError');

DOBInput.addEventListener('change', function() {
    var DOBValue = DOBInput.value;
    var currentDate = new Date();
    var minDOB = new Date(currentDate.getFullYear() - 100, currentDate.getMonth(), currentDate.getDate());
    var maxDOB = new Date(currentDate.getFullYear() - 12, currentDate.getMonth(), currentDate.getDate());
    var userDOB = new Date(DOBValue);
    var result = true; // Initialize result variable

    if (userDOB < minDOB || userDOB > maxDOB) {
        // Invalid date of birth
        birthdayError.style.display = 'block';
        DOBInput.style.borderColor = 'red';
        result = false;
    } else {
        // Valid date of birth
        birthdayError.style.display = 'none';
        DOBInput.style.borderColor = 'initial';
    }

    // Return result if needed for further processing
    return result;
});
var firstNameInput = document.getElementById('firstNameInput');
var firstNameError = document.getElementById('firstNameError');
var nameRegex = /^[a-zA-Z\s]*$/; // Allows only letters and whitespace

firstNameInput.addEventListener('change', function() {
    var firstNameValue = firstNameInput.value.trim(); // Trim the input value
    var result = true; // Initialize result variable

    if (!nameRegex.test(firstNameValue)) {
        firstNameInput.style.borderColor = 'red'; // Show error for special characters
        firstNameError.style.display = 'block'; // Display error message
        result = false;
    } else {
        firstNameInput.style.borderColor = 'initial'; // Reset border color
        firstNameError.style.display = 'none'; // Hide error message
    }

    // Return result if needed for further processing
    return result;
});

var lastNameInput = document.getElementById('lastNameInput');
var lastNameError = document.getElementById('lastNameError');
var nameRegex = /^[a-zA-Z\s]*$/; // Allows only letters and whitespace

lastNameInput.addEventListener('change', function() {
    var lastNameValue = lastNameInput.value.trim(); // Trim the input value
    var result = true; // Initialize result variable

    if (!nameRegex.test(lastNameValue)) {
        lastNameInput.style.borderColor = 'red'; // Show error for special characters
        lastNameError.style.display = 'block'; // Display error message
        result = false;
    } else {
        lastNameInput.style.borderColor = 'initial'; // Reset border color
        lastNameError.style.display = 'none'; // Hide error message
    }

    // Return result if needed for further processing
    return result;
});
</script>
</main>
