<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Activity> $activities
 */
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.dataTables.css" />
<script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.dataTables.js"></script>
<?= $this->Html->css(['customisetable']) ?>
<div class="">
<nav class="bg-light d-flex justify-content-between align-items-center">
    <div class="ml-5 mr-3">
        <h3 class='text-primary'><?= __('Activities Management') ?></h3>
        <ol class="breadcrumb" style="margin: 0;">
            <li class="breadcrumb-item text-decoration-none"><a href="<?= $this->Url->buildFromPath('Pages::index') ?>" class='text-decoration-none text-info'>Dashboard</a></li>
            <?= $this->Html->link(__('Activities'), ['action' => 'index'], ['class' => 'breadcrumb-item active text-decoration-none ']) ?>
        </ol>
    </div>
    <?= $this->Html->link('<i class="fas fa-plus fa-sm text-white-50"></i> ' . __('New Activity'), '#', ['class' => 'btn btn-sm btn-primary shadow-sm float-right newActivityModal','data-toggle' => 'modal','data-target' => '#myModal','escape' => false]) ?>
</nav>
<div class="position-absolute top-0 end-0 p-2">
        <?= $this->Flash->render() ?>
</div>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.min.js" integrity="sha512-ykZ1QQr0Jy/4ZkvKuqWn4iF3lqPZyij9iRv6sGqLRdTPkY69YX6+7wvVGmsdBbiIfN/8OdsI7HABjvEok6ZopQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<div class="ml-3 mt-3 mr-3">
<div class="nav-align-top border" style="min-height:450px; background-color:transparent;font-family:Open Sans">
  <ul class="nav nav-tabs" role="tablist">
    <?php foreach ($roles as $key => $role) : ?>
      <li class="nav-item">
        <button type="button" class="nav-link text-primary <?php echo $key === 0 ? 'active' : ''; ?>" role="tab" data-bs-toggle="tab" data-bs-target="#navs-top-align-<?php echo $role->id; ?>"><?php echo $role->name; ?></button>
      </li>
    <?php endforeach; ?>
  </ul>
  <!-- For the Role's activities -->
  <div class="tab-content" >
      <?php foreach ($roles as $key => $role) : ?>
        <div class="tab-pane fade ml-3 mr-3 <?php echo $key === 0 ? 'show active' : ''; ?>" id="navs-top-align-<?php echo $role->id; ?>">
          <div class="row">
              <div class="col-sm-8 text-primary mt-2">
                  <h2>Regular activities as a <?= $role->name?></h2>
              </div>
              <table id="tblContain" class="display nowrap" style="width:100%">
                <thead class="text-primary">
                    <tr>
                        <th>Descriptions</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody class="text-secondary">
                  <?php foreach ($activities as $activity) : ?>
                        <?php if ($activity->role_id === $role->id) : ?>
                        <tr id="activity_row_<?= $role->id; ?>">
                            <td><?= $activity->description; ?></td>
                            <td class="text-left ">
                            <div class="form-check text-left">
                            <span class="badge <?= $activity->isActive ? 'badge-success' : 'badge-secondary'; ?>"><?= $activity->isActive ? 'Active' : 'Inactive'; ?></span>
                            </div>
                            </td>
                            <td style="mix-width:150px">
                            <span class="edit-role-btn text-decoration-none text-decoration-none fa-stack" style="cursor: pointer;" data-toggle="modal" data-role-id="<?= $activity->id ?>"><i class="fa fa-square fa-stack-2x" style="color: #2BC6B1;"></i>
                                <i class="fa fa-pencil fa-stack-1x fa-inverse"></i></span>
                            <?= $this->Form->postLink('
                                <span class="fa-stack">
                                <i class="fa fa-square fa-stack-2x"  style="color: #FF3333;"></i>
                                <i class="fa-solid fa-trash fa-stack-1x" style="color: #ffffff;"></i>
                                </span> ' . __(''), ['action' => 'delete', $activity->id], ['escapeTitle' => false, 'confirm' => __("Are you sure you want to delete {0} {1}'s account?")]) ?>
                            </td>
                        </tr>
                        <?php endif; ?>

                  <?php endforeach; ?>
                </tbody>
              </table>
          </div>
        </div>
      <?php endforeach; ?>
  </div>
</div>

</div>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>


<!-- MODAL EDIT -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #7fcbae;" >
        <h5 class="modal-title" id="exampleModalLabel">Edit Activities</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <?= $this->Form->create(null, ['id' => 'yourFormId']) ?>
      <div class="modal-body" id="modalBody">
        <!-- Modal content will be inserted here -->
      </div>
      <div class="modal-footer">
      <button type="button" class="text-decoration-none btn btn-sm btn-outline-secondary" style="color: #343A40" data-bs-dismiss="modal">Close</button>
        <?= $this->Form->button(__('Submit'), ['class' => 'text-decoration-none btn btn-sm btn-outline-info', 'onClick' => 'return validateEditForm();']) ?>
        <?= $this->Form->end() ?>
      </div>
    </div>
  </div>
</div>

<!-- MODAL ADD -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
            <div class="modal-header" style="background-color: #7fcbae;">
            <h5 class="modal-title" id="shiftModalLabel">
                Add Activity
            </h5>
              <button type="button" class="btn-close" data-bs-dismiss="*myModal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                      <?= $this->Form->create(null, ['url' => ['controller' => 'Activities','action' => 'add']]); ?>
                      <div class="mb-3">
                          <label for="activity-description" class="form-label">Activity Description <span class="mandatory" style="color:red">*</span></label>
                          <?= $this->Form->control('description', [
                              'id' => 'adddescription', // Unique ID for the add modal
                              'class' => 'form-control',
                              'type' => 'textarea',
                              'label' => false,
                              'maxlength' => 255,
                          ]); ?>
                          <span id="adddescriptionError" style="color: red; display: none;"></span>
                      </div>

                      <div class="mb-3">
                          <label class="form-check-label" for="activity-isActive">Archieve </label>
                          <div class="form-check form-switch">
                              <?= $this->Form->checkbox('isActive', [
                                  'id' => 'activity-isActive',
                                  'class' => 'form-check-input',
                                  'label' => false,
                                  'hiddenField' => false,
                                  'checked' => true,
                              ]); ?>
                          </div>
                      </div>
                      <div class="mb-3">
                          <label for="activity-role_id" class="form-label">Assigned to: <span class="mandatory" style="color:red">*</span></label>
                          <?php
                            $options = [];
                            foreach ($roles as $role) {
                                $options[$role->id] = $role->name;
                            }
                            echo $this->Form->control('role_id', ['options' => $options, 'label' => false,'class' => 'form-select']);
                            ?>
                      </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <?= $this->Form->button('Add', ['class' => 'btn btn-outline-primary', 'onClick' => 'return validateAddForm();']); ?>
                <?= $this->Form->end(); ?>
            </div>
    </div>
  </div>
</div>

<!-- MODAL JS EIDT  -->
<script>
$('.edit-role-btn').click(function() {
    // Get the role ID from the data attribute
    var id = $(this).data('role-id');
    var formAction = '<?= $this->Url->build(['controller' => 'activities', 'action' => 'edit', '__ID__']) ?>';
    formAction = formAction.replace('__ID__', id);
    $('#yourFormId').attr('action', formAction);

    // Make an AJAX request
    $.ajax({
        type: 'get',
        url: 'activities/statesAjaxActivity',
        data: { id: id }, // Pass the id as data
        beforeSend: function(xhr) {
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        },
        success: function(response) {
          console.log(response);
            if (response) {
                // Build the modal content
                var modalContent = '<div class="form-group">';
                modalContent += '<label for="edit-description" class="col-form-label">Activity: <span class="mandatory" style="color:red">*</span></label>';
                modalContent += '<textarea id="edit-description" name="description" class="form-control min-height-150" style="min-height: 150px;" maxlength="255">' + response.result.description + '</textarea>';
                modalContent += '<span id="editDescriptionError" style="color: red; display: none;"></span>'
                modalContent += '</div>';
                modalContent += '<div class="form-check form-switch">';
                modalContent += '<input type="hidden" id="isActiveHidden" name="isActive" value="' + (response.result.isActive ? '1' : '0') + '">';
                modalContent += '<input class="form-check-input" type="checkbox" id="flexCheckIndeterminate" onchange="updateHiddenInput()" ' + (response.result.isActive ? 'checked' : '') + ' value="1">';
                modalContent += '<label class="form-check-label" for="flexCheckIndeterminate">Archieve </label>';
                modalContent += '</div>';
                modalContent += '</fieldset>';
                modalContent += '</div>';
                modalContent += '<div class="form-group">';
                modalContent += '<label for="role" class="col-form-label">Role: <span class="mandatory" style="color:red">*</span></label>';
                modalContent += '<select name="role_id" class="form-control" id="role">';
response.roles.forEach(function(role) {
    modalContent += '<option value="' + role.id + '"' + (role.id === response.result.role_id ? ' selected' : '') + '>' + role.name + '</option>';
});
modalContent += '</select>';




                // Set the modal body content
                $('#modalBody').html(modalContent);

                // Show the modal
                $('#exampleModal').modal('show');
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

<!-- table -->
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
    let table = new DataTable('table.display', {
      autoWidth: true,
      info: false,
        paging: false,
        searching: false,
        responsive: true

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
<script>
function validateAddForm() {
    var result = true;
    var descriptionTextarea = document.getElementById('adddescription');
    var descriptionError = document.getElementById('adddescriptionError');
    var minLength = 5; // Minimum allowed length for the description
    var maxLength = 255; // Maximum allowed length for the description

    if (descriptionTextarea.value.trim().length === 0) {
        descriptionTextarea.style.borderColor = 'red';
        descriptionError.textContent = 'Description cannot be empty';
        descriptionError.style.display = 'block';
        result = false;
    } else if (descriptionTextarea.value.length < minLength) {
        descriptionTextarea.style.borderColor = 'red';
        descriptionError.textContent = 'Description must be at least ' + minLength + ' characters long';
        descriptionError.style.display = 'block';
        result = false;
    } else if (descriptionTextarea.value.length > maxLength) {
        descriptionTextarea.style.borderColor = 'red';
        descriptionError.textContent = 'Description cannot exceed ' + maxLength + ' characters';
        descriptionError.style.display = 'block';
        result = false;
    } else {
        descriptionTextarea.style.borderColor = 'initial';
        descriptionError.style.display = 'none';
    }

    return result;
}
function validateEditForm() {
    var editDescriptionTextarea = document.getElementById('edit-description');
    var editDescriptionError = document.getElementById('editDescriptionError');
    var minLength = 5; // Minimum allowed length for the description
    var maxLength = 255; // Maximum allowed length for the description

    if (editDescriptionTextarea.value.trim().length === 0) {
        editDescriptionTextarea.style.borderColor = 'red';
        editDescriptionError.textContent = 'Description cannot be empty';
        editDescriptionError.style.display = 'block';
        return false;
    } else if (editDescriptionTextarea.value.length < minLength) {
        editDescriptionTextarea.style.borderColor = 'red';
        editDescriptionError.textContent = 'Description must be at least ' + minLength + ' characters long';
        editDescriptionError.style.display = 'block';
        return false;
    } else if (editDescriptionTextarea.value.length > maxLength) {
        editDescriptionTextarea.style.borderColor = 'red';
        editDescriptionError.textContent = 'Description cannot exceed ' + maxLength + ' characters';
        editDescriptionError.style.display = 'block';
        return false;
    } else {
        editDescriptionTextarea.style.borderColor = 'initial';
        editDescriptionError.style.display = 'none';
        return true;
    }
}
</script>
