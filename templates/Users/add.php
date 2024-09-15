<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="">
<nav class="bg-light d-flex justify-content-between align-items-center">
    <div class="ml-5 mr-3">
        <h3 class='text-primary'><?= __('Employee Management') ?></h3>
        <ol class="breadcrumb" style="margin: 0;">
            <li class="breadcrumb-item text-decoration-none"><a href="<?= $this->Url->buildFromPath('Pages::index') ?>" class='text-decoration-none text-info'>Dashboard</a></li>
            <?= $this->Html->link(__('Employees'), ['action' => 'index'], ['class' => 'breadcrumb-item text-info text-decoration-none ']) ?>
            <?= $this->Html->link(__('Add Employee'), ['action' => 'add'], ['class' => 'breadcrumb-item active text-decoration-none ']) ?>
        </ol>
    </div>
    <?= $this->Html->link('<i class="fas fa-plus fa-sm text-white-50"></i> ' . __('New Employee'), ['action' => 'add'], ['class' => 'btn btn-sm btn-primary shadow-sm', 'escape' => false,]) ?>
</nav>
<div class="position-absolute top-0 end-0 p-2">
        <?= $this->Flash->render() ?>
    </div>

</div>
<div class="card-body p-4 p-sm-5 text-info">
            <h5 class="card-title text-center mb-2 fw-light">Add New Account</h5>
            <?= $this->Form->create($user) ?>
            <fieldset>
                <div class="row  mb-3">
                <?= $this->Form->control('avatarimg', [
                    'type' => 'file',
                    'accept' => 'image/*',
                    'class' => 'form-control ',
                    'label' => 'Profile Image',
                ]) ?>
                </div>
            <div class="row">
                <div class="col">
                    <div class="form-floating mb-3">
                    <?= $this->Form->control('f_name', [
                        'class' => 'form-control',
                        'label' => 'First Name <span class="mandatory" style="color:red">*</span>',
                        'autofocus' => true,
                        'maxLength' => 55,
                        'id' => 'firstNameInput', // Ensure you have this ID attribute
                        'escape' => false, // Make sure HTML entities are not escaped
                    ]) ?>
                        <span id="firstNameError" style="color: red; display: none;"></span>
                    </div>
                </div>
                <div class="col">
                    <div class="form-floating mb-3">
                        <?= $this->Form->control('l_name', [
                            'class' => 'form-control',
                            'label' => 'Last Name <span class="mandatory" style="color:red">*</span>',
                            'maxLength' => 55,
                            'id' => 'lastNameInput', // Add this line
                            'escape' => false, // Make sure HTML entities are not escaped
                        ]) ?>
                        <span id="lastNameError" style="color: red; display: none;">Last name should not contain special characters.</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="form-floating mb-3">
                        <?= $this->Form->control('email', ['class' => 'form-control','label' => 'Email <span class="mandatory" style="color:red">*</span>', 'maxLength' => 255, 'escape' =>false]) ?>
                        <span id="emailError" style="color: red; display: none;">Please select at least one role.</span>
                    </div>
                </div>
                <div class="col">
                <div class="form-floating mb-3">
                <?= $this->Form->control('phone', [
                    'class' => 'form-control',
                    'label' => 'Phone Number <span class="mandatory" style="color:red">*</span>',
                    'maxLength' => 10,
                    'minLength' => 10,
                    'id' => 'phoneInput',
                    'escape' => false,
                    ]) ?>
                    <span id="phoneError" style="color: red; display: none;">Please enter a valid phone number starting with 0 and followed by 9 digits.</span>
                </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="form-floating mb-3">
                        <?= $this->Form->control('address', ['class' => 'form-control','label' => 'Home Address <span class="mandatory" style="color:red">*</span>', 'escape' => false]) ?>
                        <span id="addressError" style="color: red; display: none;"></span>
                    </div>
                </div>
            </div>

                <!-- [EMPLOYEE, MANAGER, ADMIN] SELECT - ADMIN VIEW -->
                <?php if ($this->Identity->get('isAdmin') == 1) : ?>
                <div class="row">
                    <div class="form-floating mb-3" id="rolesContainer">
                        <?= $this->Form->control('role', [
                            'class' => 'form-select',
                            'label' => 'Role <span class="mandatory" style="color:red">*</span>',
                            'options' => [
                                'isAdmin' => 'Admin',
                                'isManager' => 'Manager',
                                'isEmployee' => 'Employee',
                            ],
                            'empty' => 'Select Role',
                            'id' => 'roleSelect',
                            'escape' => false,
                        ]) ?>
                        <span id="rolesError" style="color: red; display: none;">Please select a role.</span>
                    </div>
                </div>

                    <?= $this->Form->hidden('isAdmin', ['id' => 'isAdminInput']) ?>
                    <?= $this->Form->hidden('isManager', ['id' => 'isManagerInput']) ?>
                    <?= $this->Form->hidden('isEmployee', ['id' => 'isEmployeeInput']) ?>

                    <!-- [EMPLOYEE, MANAGER] SELECT - MANAGER VIEW -->
                <?php elseif ($this->Identity->get('isManager') == 1) : ?>
                    <div class="row">
                        <div class="form-floating mb-3 text-center" id="rolesContainer">
                            <?= $this->Form->control('role', [
                                'class' => 'form-select',
                                'label' => 'Role',
                                'options' => [
                                    'isManager' => 'Manager',
                                    'isEmployee' => 'Employee',
                                ],
                                'empty' => 'Select Role',
                                'id' => 'roleSelect',
                            ]) ?>
                            <span id="rolesError" style="color: red; display: none;">Please select a role.</span>
                        </div>
                    </div>

                    <?= $this->Form->hidden('isManager', ['id' => 'isManagerInput']) ?>
                    <?= $this->Form->hidden('isEmployee', ['id' => 'isEmployeeInput']) ?>

                <?php endif; ?>

                <div class="form-floating mb-3">
                    <?= $this->Form->control('password', [
                        'class' => 'form-control',
                        'label' => 'Default Password <span class="mandatory" style="color:red">*</span>   <i class="fa-regular fa-circle-question" data-bs-toggle="popover" data-bs-content="New user will be send a set own passwor email. This will be the default password for them to access their account if email did not send out expectedly."></i>',
                        'value' => 'DefaultPassword', // Set your default value here
                        'readonly' => true, // Make the field readonly
                        'type' => 'text',
                        'escape' => false,
                        'value' => 'DefaultPassword', // Set your default value here
                        'readonly' => true, // Make the field readonly
                        'type' => 'text',
                        'escape' => false,
                    ]) ?>
                    
                </div>

            <hr>
              <div class="d-grid mb-2">
                <?= $this->Form->hidden('atLeastOneChecked', ['id' => 'atLeastOneChecked']) ?>
                <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-outline-info', 'onClick' => 'return validateCheckbox();']) ?>
                <?= $this->Form->end() ?>
              </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script>
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
  return new bootstrap.Popover(popoverTriggerEl)
})
</script>
<script>
function validateCheckbox() {
    var result = true;
    var phoneInput = document.getElementById('phoneInput');
    var phoneValue = phoneInput.value;

    var phoneError = document.getElementById('phoneError');

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

// First name validation
var firstNameInput = document.getElementById('firstNameInput');
var firstNameValue = firstNameInput.value;
var firstNameError = document.getElementById('firstNameError');
var nameRegex = /^[a-zA-Z\s]*$/; // Allows only letters and whitespace

if(firstNameValue.trim() === ''){
    firstNameInput.style.borderColor = 'red'; // Show error for empty or special characters
    firstNameError.style.display = 'block'; // Display error message
    firstNameError.textContent = 'This field should not be blanked.'
    result = false;
}else if(!nameRegex.test(firstNameValue)){
    firstNameInput.style.borderColor = 'red'; // Show error for empty or special characters
    firstNameError.style.display = 'block'; // Display error message
    firstNameError.textContent = 'First name should not contain special characters.'
    result = false;
}else{
    firstNameInput.style.borderColor = 'initial'; // Reset border color
    firstNameError.style.display = 'none'; // Hide error message
}

    //last name validation
    var lastNameInput = document.getElementById('lastNameInput');
    var lastNameValue = lastNameInput.value;
    var lastNameError = document.getElementById('lastNameError');
    var nameRegex = /^[a-zA-Z\s]*$/; // Allows only letters and whitespace

    if (!nameRegex.test(lastNameValue)) {
        lastNameInput.style.borderColor = 'red'; // Show error for special characters
        lastNameError.style.display = 'block'; // Display error message
        result = false;
    }else if(lastNameValue.trim() === ''){
        lastNameInput.style.borderColor = 'red'; // Show error for special characters
        lastNameError.style.display = 'block'; // Display error message
        lastNameError.textContent = 'This field should not be blanked.'
        result = false;

    }
     else {
        lastNameInput.style.borderColor = 'initial'; // Reset border color
        lastNameError.style.display = 'none'; // Hide error message
    }
    //validation for address
    var addressInput = document.getElementById('address');
    var addressInputValue = addressInput.value;
    var addressInputError = document.getElementById('addressError');
            if (addressInputValue.trim() === '') {
                addressInput.style.borderColor = 'red'; // Show error for special characters
                addressInputError.style.display = 'block'; // Display error message
                addressInputError.textContent = 'This field should not be blanked.'
                result = false;
            }

    var emailInput = document.getElementById('email');
    var emailError = document.getElementById('emailError'); // You need to set up an error div for email
    var url = '/users/check-email?email=' + encodeURIComponent(email);
    if (addressInputValue.trim() === '') {
                emailInput.style.borderColor = 'red';
                emailError.style.display = 'block';
                emailError.textContent = 'This should not be blanked';
                result = false;
    }else{
    $.ajax({
        type: 'GET',
        url: '<?= $this->Url->build(['controller' => 'users', 'action' => 'checkEmail'])?>',
        data: { email: emailInput.value }, // Pass the id as data
        beforeSend: function(xhr) {
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        },
        success: function (exists) {
            if (exists) {
                emailInput.style.borderColor = 'red';
                emailError.style.display = 'block';
                emailError.textContent = 'Email already in use.';
                result = false;
            } 
            
            else {

                emailInput.style.borderColor = 'initial';
                emailError.style.display = 'none';
            }
        },
        error: function(xhr, status, error) {
            console.error("An error occurred: " + error);
        }
    });
}

    return result ;

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
<!-- On Change Listerner -->
<script>
    var firstNameInput = document.getElementById('firstNameInput');
var firstNameError = document.getElementById('firstNameError');
var nameRegex = /^[a-zA-Z\s]*$/; // Allows only letters and whitespace

firstNameInput.addEventListener('change', function() {
    var firstNameValue = firstNameInput.value.trim(); // Trim the input value

    if (firstNameValue === '') {
        firstNameInput.style.borderColor = 'red'; // Show error for empty input
        firstNameError.style.display = 'block'; // Display error message
        firstNameError.textContent = 'This field should not be blank.';
    } else if (!nameRegex.test(firstNameValue)) {
        firstNameInput.style.borderColor = 'red'; // Show error for special characters
        firstNameError.style.display = 'block'; // Display error message
        firstNameError.textContent = 'First name should not contain special characters.';
    } else {
        firstNameInput.style.borderColor = 'initial'; // Reset border color
        firstNameError.style.display = 'none'; // Hide error message
    }
});

var lastNameInput = document.getElementById('lastNameInput');
var lastNameError = document.getElementById('lastNameError');
var nameRegex = /^[a-zA-Z\s]*$/; // Allows only letters and whitespace

lastNameInput.addEventListener('change', function() {
    var lastNameValue = lastNameInput.value.trim(); // Trim the input value

    if (!nameRegex.test(lastNameValue)) {
        lastNameInput.style.borderColor = 'red'; // Show error for special characters
        lastNameError.style.display = 'block'; // Display error message
        lastNameError.textContent = 'Last name should not contain special characters.';
    } else if (lastNameValue === '') {
        lastNameInput.style.borderColor = 'red'; // Show error for empty input
        lastNameError.style.display = 'block'; // Display error message
        lastNameError.textContent = 'This field should not be blank.';
    } else {
        lastNameInput.style.borderColor = 'initial'; // Reset border color
        lastNameError.style.display = 'none'; // Hide error message
    }
});

var phoneInput = document.getElementById('phoneInput');
var phoneError = document.getElementById('phoneError');

phoneInput.addEventListener('change', function() {
    var phoneValue = phoneInput.value;

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
});

</script>
