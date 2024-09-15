<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Role> $roles
 * @var iterable<\App\Model\Entity\Activity> $activities
 */

?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
<?= $this->Html->meta('csrfToken', $this->request->getAttribute('csrfToken')) ?>
<!-- Resource for Datatables Plugins -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/3.0.1/css/responsive.dataTables.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.css" />

<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.dataTables.css" />
<script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.dataTables.js"></script>
<?= $this->Html->css(['customisetable']) ?>
<?= $this->Html->css(['customisetable']) ?>
<main>
<div class="position-relative">
    <nav class="bg-light d-flex justify-content-between align-items-center">
        <div class="ml-5 mr-3">
            <h3 class='text-primary'><?= __('Roles Management') ?></h3>
            <ol class="breadcrumb" style="margin: 0;">
                <li class="breadcrumb-item text-decoration-none"><a href="<?= $this->Url->buildFromPath('Pages::index') ?>" class='text-decoration-none text-info'>Dashboard</a></li>
                <?= $this->Html->link(__('Roles'), ['action' => 'index'], ['class' => 'breadcrumb-item active text-decoration-none ']) ?>
            </ol>
        </div>
        <?= $this->Html->link('<i class="fas fa-plus fa-sm text-white-50"></i> ' . __('New Roles'), '#', ['class' => 'btn btn-sm btn-primary shadow-sm', 'data-toggle' => 'modal', 'data-target' => '#exampleModal', 'data-whatever' => '@mdo', 'escape' => false, 'onclick' => 'return false;']) ?>
    </nav>
    <div class="position-absolute top-0 end-0 p-2">
        <?= $this->Flash->render() ?>
    </div>
</div>
<?= $this->Html->css(['table']); ?>
<div class="ml-5 mr-3">
<div class="users index content mt-5 ml-2 mr-2 text-primary" >
    <div>
        <table id="tblContain"  class="user-list display nowrap" style="width:100%" >
            <thead>
                <th>Role Names</th>
                <th>Eligible</th>
                <th>Status</th>
                <th>Actions</th>
            </thead>
            <tfoot>
                <th>Role Names</th>
                <th>Eligible</th>
                <th>Status</th>
                <th>Actions</th>
            </tfoot>
            <tbody class='text-secondary'>
            <?php foreach ($roles as $role) : ?>
                <tr>
                    <td style="max-width:100px"><?= $role->name ?></td>
                    <td style="max-width: 250px; overflow: hidden; text-overflow: ellipsis;"><?= $role->eligible ?></td>

                    <td>
                    <div class="form-check text-left">        
                      <span class="badge <?= $role->isActive ? 'badge-success' : 'badge-secondary'; ?>"><?= $role->isActive ? 'Active' : 'Inactive'; ?></span>
                    </div>
                    </td>
                    <td  class='text-center'>
                            <a href="<?= $this->Url->buildFromPath('Roles::view', [$role->id]) ?>" class="table-link">
                                <span class="fa-stack">
                                <i class="fa fa-square fa-stack-2x" style="color:#2B8EC6;"></i>
                                <i class="fa fa-plus fa-stack-1x fa-inverse"></i>
                                </span>
                            </a>
                            <span class="edit-role-btn text-decoration-none fa-stack" 
                                data-toggle="modal"  
                                data-role-id="<?= $role->id ?>"
                                style="cursor: pointer;">
                                <i class="fa fa-square fa-stack-2x" style="color: #2BC6B1;"></i>
                                <i class="fa fa-pencil fa-stack-1x fa-inverse"></i>
                            </span>
                        
                            <?= $this->Form->postLink('
                                <span class="fa-stack">
                                <i class="fa fa-square fa-stack-2x"  style="color: #FF3333;"></i>
                                <i class="fa-solid fa-trash fa-stack-1x" style="color: #ffffff;"></i>
                                </span> ' . __(''), ['action' => 'delete', $role->id], ['escapeTitle' => false, 'confirm' => __("Are you sure you want to delete {0}?", $role->name)]) ?>

                    </td>
                </tr>
            <?php endforeach; ?>

            </tbody>
        </table>
    </div>
</div>

</div>
<style>
table td {
    max-width: 250px;/* Set a fixed max-width or adjust as needed */
    white-space: normal; /* Allows text to wrap */
    text-overflow: ellipsis; /* This will be overridden by white-space: normal */
    word-wrap: break-word; /* Ensures words break and wrap as needed */
    overflow: hidden; /* Hide overflow and ensure text fits within the cell */
    vertical-align: top; /* Optional: aligns text to the top of the cell */
}
</style>
<script>
jQuery(document).ready(function($) {
    var table = $('#tblContain').DataTable({
        responsive: true,
    });

});
jQuery(document).ready(function($) {
    // Event listener for clicking on any cell
    $('table.display').on('click', 'td', function() {
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

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>



<!-- MODAL Add -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #7fcbae;">
        <h5 class="modal-title">
               Add New Role
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?= $this->Form->create(null, ['url' => ['controller' => 'Roles','action' => 'add'],'id' => 'addRoleForm']); ?>

        <div class="form-group">
    <label for="addRoleName" class="col-form-label">Role's Name <span class="mandatory" style="color:red">*</span></label>
    <?= $this->Form->control('name', [
        'class' => 'form-control',
        'type' => 'text',
        'label' => false,
        'maxlength' => 55,
        'id' => 'addRoleNameInput', // Unique ID for the Add form
    ])?>
    <span id="addRoleNameError" style="color: red; display: none;"></span>
    <!-- Similarly, add unique IDs for other inputs like 'eligible' if needed -->
</div>


<div class="form-group">
    <label for="addEligible" class="col-form-label">Eligibles For The Role <span class="mandatory" style="color:red">*</span></label>
    <?= $this->Form->control('eligible', [
        'class' => 'form-control',
        'type' => 'textarea',
        'label' => false,
        'maxlength' => 255,
        'id' => 'addEligibleTextarea', // Unique ID for the Add form
    ])?>
    <span id="addEligibleError" style="color: red; display: none;"></span>
</div>


          <div class="form-group">
            <div class="form-check form-switch">
            <?= $this->Form->checkbox('isActive', [
                'class' => 'form-check-input', // Bootstrap 4 class for checkboxes
                'label' => false, // Specify the label text here
                'hiddenField' => false, // Disable the hidden field
                'checked' => true, // Set the initial state of the checkbox (optional)
            ]) ?>
            <label for="">Active</label>
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="text-decoration-none btn btn-large btn-outline-secondary" data-dismiss="modal">Close</button>
        <?= $this->Form->button(__('Add'), ['class' => 'text-decoration-none btn btn-large btn-outline-info', 'onClick' => 'return validateAddForm();']) ?>
        <?= $this->Form->end() ?>
      </div>
    </div>
  </div>
</div>

<script>
    $(document).ready(function() {
        $('#addRoleForm').submit(function(e) {
            var roleName = $('#RoleName').val().trim(); // Get the value of the role name input field
            var eligible = $('#Eligible').val().trim(); // Get the value of the eligible input field

            // Check if the input fields are not empty
            if (roleName === '' || eligible === '') {
                alert('Please fill in all fields'); // Show an alert if any of the fields are empty
                e.preventDefault(); // Prevent the form from submitting
            }
        });
    });
</script>

<!-- MODAL EDIT -->
<div class="modal fade" id="yourModalId" tabindex="-1" aria-labelledby="yourModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #7fcbae;">
                    <h5 class="modal-title" id="shiftModalLabel">
                Edit <span id="roleName" style="display: inline-block;"></span>
            </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        
        
      </div>
      <?= $this->Form->create(null, ['id' => 'yourFormId']) ?>

      <div class="modal-body" id="modalBody">
        <!-- Modal content will be inserted here -->
      </div>
      <div class="modal-footer">
        <button type="button" class="text-decoration-none btn btn-sm btn-outline-secondary" style="color: #343A40" data-bs-dismiss="modal">Close</button>
        <?= $this->Form->button(__('Submit'), ['class' => 'text-decoration-none btn btn-sm btn-outline-info', 'onClick' => 'return validateCheckbox();']) ?>
        <?= $this->Form->end() ?>
      </div>
    </div>
  </div>
</div>


<script>
// Add a click event listener to all elements with the class 'edit-role-btn'
$('.edit-role-btn').click(function() {
    // Get the role ID from the data attribute
    var id = $(this).data('role-id');
    
    // Set the action URL for the form
    var formAction = '<?= $this->Url->build(['controller' => 'roles', 'action' => 'edit', '__ID__']) ?>';
    formAction = formAction.replace('__ID__', id);
    $('#yourFormId').attr('action', formAction);
    
    // Make an AJAX request
    $.ajax({
        type: 'get',
        url: 'roles/statesAjax',
        data: { id: id }, // Pass the id as data
        beforeSend: function(xhr) {
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        },
        success: function(response) {
          console.log(response);
            if (response) {
                document.getElementById('roleName').innerText = response.name;
                
                // Build the modal content
                var modalContent = '<div class="roles form content">';
                modalContent += '<fieldset>';
                modalContent += '<div class="form-group">';
                modalContent += '<label for="recipient-name" class="col-form-label">Role\'s Name: <span class="mandatory" style="color:red">*</span></label>';
                modalContent += '<input id="roleNameInput" name="name" type="text" class="form-control" maxlength="55" value="' + response.name + '" >';
                modalContent += '<span id="roleNameError" style="color: red; display: none;">Error message here.</span>';
                modalContent += '</div>';
                modalContent += '<div class="form-group">';
                modalContent += '<label for="message-text" class="col-form-label">Eligible: <span class="mandatory" style="color:red">*</span></label>';
                modalContent += '<textarea id="eligibleTextarea" name="eligible" class="form-control min-height-150" style="min-height: 150px;" maxlength="255">' + response.eligible + '</textarea>';
                modalContent += '<span id="eligibleError" style="color: red; display: none;"></span>';
                modalContent += '</div>';
                modalContent += '<div class="form-check form-switch">';
                modalContent += '<input type="hidden" id="isActiveHidden" name="isActive" value="' + (response.isActive ? '1' : '0') + '">';
modalContent += '<input class="form-check-input" type="checkbox" id="flexCheckIndeterminate" onchange="updateHiddenInput()" ' + (response.isActive ? 'checked' : '') + ' value="1">';

                modalContent += '<label class="form-check-label" for="flexCheckIndeterminate">Is Active ?</label>';
                modalContent += '</div>';
                modalContent += '</fieldset>';
                modalContent += '</div>';
                
                // Set the modal body content
                $('#modalBody').html(modalContent);
                
                // Show the modal
                $('#yourModalId').modal('show');
            }
        },
        error: function(xhr, status, error) {
            console.error("An error occurred: " + error);
        }
    });
});
function updateHiddenInput() {
    var checkbox = document.getElementById('flexCheckIndeterminate');
    var hiddenInput = document.getElementById('isActiveHidden');
    hiddenInput.value = checkbox.checked ? '1' : '0';
}
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('flexCheckIndeterminate').addEventListener('change', updateHiddenInput);
    updateHiddenInput(); // Set initial value correctly based on the loaded state
});

</script>
<script>
function validateCheckbox() {
  var roleNameInput = document.getElementById('roleNameInput');
  var roleNameError = document.getElementById('roleNameError');
  // Regular expression allows only letters and spaces
  var validNameRegex = /^[a-zA-Z\s]*$/;
  var result = true;

  if (!roleNameInput.value.trim()) {
      roleNameInput.style.borderColor = 'red';
      roleNameError.textContent = 'Role name cannot be empty'; // Error message for empty input
      roleNameError.style.display = 'block';
      result = false;
  } else if (!validNameRegex.test(roleNameInput.value)) {
      roleNameInput.style.borderColor = 'red';
      roleNameError.textContent = 'Role name should not contain digits or special characters.'; // Error message for invalid characters
      roleNameError.style.display = 'block';
      result = false;
  } else {
      roleNameInput.style.borderColor = 'initial';
      roleNameError.style.display = 'none';
  }
    //Eligible 
    var eligibleTextarea = document.getElementById('eligibleTextarea');
    var eligibleError = document.getElementById('eligibleError');
    var minLength = 5; // Define the minimum length requirement

    if (eligibleTextarea.value.length < 5) {
        eligibleTextarea.style.borderColor = 'red';
        eligibleError.textContent = `Eligible information must be at least ${minLength} characters.`;
        eligibleError.style.display = 'block';
        result = false;
    } else {
        eligibleTextarea.style.borderColor = 'initial';
        eligibleError.style.display = 'none';
    }

    return result;
}
function validateAddForm() {
    var addRoleNameInput = document.getElementById('addRoleNameInput');
    var addRoleNameError = document.getElementById('addRoleNameError');
    // Regular expression allows only letters and spaces
    var validNameRegex = /^[a-zA-Z\s]*$/;
    var result = true;

    // Validation for Role's Name
    if (!addRoleNameInput.value.trim()) {
        addRoleNameInput.style.borderColor = 'red';
        addRoleNameError.textContent = 'Role name cannot be empty';
        addRoleNameError.style.display = 'block';
        result =  false;
    } else if (!validNameRegex.test(addRoleNameInput.value)) {
        addRoleNameInput.style.borderColor = 'red';
        addRoleNameError.textContent = 'Role name should not contain digits or special characters';
        addRoleNameError.style.display = 'block';
        result =  false;
    } else {
        addRoleNameInput.style.borderColor = 'initial';
        addRoleNameError.style.display = 'none';
    }

    var addEligibleTextarea = document.getElementById('addEligibleTextarea');
    var addEligibleError = document.getElementById('addEligibleError');
    var minLength = 5; // Define the minimum length requirement

    if (addEligibleTextarea.value.length < minLength) {
        addEligibleTextarea.style.borderColor = 'red';
        addEligibleError.textContent = `Eligible information must be at least ${minLength} characters.`;
        addEligibleError.style.display = 'block';
        result =  false;
    } else {
        addEligibleTextarea.style.borderColor = 'initial';
        addEligibleError.style.display = 'none';
    }

    return result;
}
</script>
</main>

