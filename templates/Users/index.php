<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\User> $users
 */

?>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>


<!-- Resource for Datatables Plugins -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/3.0.1/css/responsive.dataTables.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.css" />

<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.datatables.net/2.0.3/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.1/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.1/js/responsive.dataTables.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.dataTables.css" />
<?= $this->Html->css(['customisetable']) ?>

<div class="">
<nav class="bg-light d-flex justify-content-between align-items-center">
    <div class="ml-5 mr-3">
        <h3 class='text-primary'><?= __('Employee Management') ?></h3>
        <ol class="breadcrumb" style="margin: 0;">
            <li class="breadcrumb-item text-decoration-none"><a href="<?= $this->Url->buildFromPath('Pages::index') ?>" class='text-decoration-none text-info'>Dashboard</a></li>
            <?= $this->Html->link(__('Employees'), ['action' => 'index'], ['class' => 'breadcrumb-item active text-decoration-none ']) ?>
        </ol>
    </div>
    <?= $this->Html->link('<i class="fas fa-plus fa-sm text-white-50"></i> ' . __('New Employee'), ['action' => 'add'], ['class' => 'btn btn-sm btn-primary shadow-sm', 'escape' => false,]) ?>
</nav>
<div class="position-absolute top-0 end-0 p-2">
        <?= $this->Flash->render() ?>
    </div>

</div>
<?= $this->Html->css(['table']); ?>
<div class="ml-5 mr-3">
<div class="users index content mt-5 ml-2 mr-2 text-primary">
    <div class="table-responsive">
        <table id="tblContain" class="display nowrap user-list" style="width:100%">
            <thead class="text-primary">
            <tr>
                <th><span>User</span></th>
            <th><span>Phone</span></th>
                <th class="text-center"><span>Available Today</span></th>
                <th><span>Email</span></th>
                <th>Actions</th>
            </tr>
            </thead>
            <tfoot class="text-primary">
            <tr>
                <th><span>User</span></th>
            <th><span>Phone</span></th>
                <th class="text-center"><span>Available Today</span></th>
                <th><span>Email</span></th>
                <th>Actions</th>
            </tr>
            </tfoot>
            <tbody class="text-secondary">
            <?php foreach ($users as $user) : ?>
            <tr>
                <td>
                <?= $this->Html->image($user->avatarimg, ['class' => 'rounded-circle', 'style' => 'width: 50px; height: 50px; object-fit: cover; border-radius: 50%;']) ?>

                <a href="<?= $this->Url->buildFromPath('Users::view', [$user->id]) ?>" class="user-link text-primary text-decoration-none"><?= ucfirst(strtolower($user->f_name)) ?> <?= ucfirst(strtolower($user->l_name)) ?></a>

                    <?php if ($user->isAdmin == 1) : ?>
                        <span class="badge bg-warning">Admin</span>
                    <?php elseif ($user->isManager == 1) : ?>
                        <span class="badge bg-primary">Manager</span>
                    <?php elseif ($user->isEmployee == 1) : ?>
                        <span class="badge bg-secondary">Employee</span>
                    <?php else : ?>
                        <span class="badge bg-danger">Super Admin</span>
                    <?php endif; ?>
                </td>
                 <td>
                    <?= h($user->phone) ?>
                </td>
                
                <td class="text-center">
                <?php if ($user->isFree === 'Available'): ?>
                    <span class="badge badge-success"><?= $user->isFree; ?></span>
                <?php else : ?>
                    <span class="badge badge-danger">Unavailable</span>
                <?php endif; ?>
                </span>

                </td>
                <td>
                <?= $user->email ?>
                </td>
                <td style="width: 20%;">

                        <!-- Admin able to view/edit/delete all users -->
                        <?php if ($this->Identity->get('isAdmin') == 1) : ?>
                        <?php if($user->isAdmin != 0 || $user->isManager != 0 || $user->isEmployee != 0) : ?>
                            <a href="<?= $this->Url->buildFromPath('Users::view', [$user->id]) ?>" class="table-link">
                                <span class="fa-stack" data-bs-toggle="tooltip" data-bs-title="View">
                                <i class="fa fa-square fa-stack-2x" style="color:#2B8EC6;"></i>
                                <i class="fa fa-plus fa-stack-1x fa-inverse"></i>
                                </span>
                            </a>
                            <a href="<?= $this->Url->buildFromPath('Users::edit', [$user->id]) ?>" class="table-link">
                            <span class="fa-stack" data-bs-toggle="tooltip" data-bs-title="Edit">
                                <i class="fa fa-square fa-stack-2x" style="color: #2BC6B1;" ></i>
                                <i class="fa fa-pencil fa-stack-1x fa-inverse"></i>
                            </span>
                        </a>
                        <?= $this->Form->postLink('
                        <span class="fa-stack" data-bs-toggle="tooltip" data-bs-title="Delete">
                        <i class="fa fa-square fa-stack-2x"  style="color: #FF3333;"></i>
                        <i class="fa-solid fa-trash fa-stack-1x" style="color: #ffffff;"></i>
                        </span> ' . __(''), ['action' => 'delete', $user->id], ['escapeTitle' => false, 'confirm' => __("Are you sure you want to delete {0} {1}'s account?", $user->f_name, $user->l_name)]) ?>         
                        <?php endif; ?>
                        <!--
                        Manager only able to delete managers/employees, cannot delete admins
                        Manager can also only edit managers/employees, cannot edit admins
                        -->
                        <?php elseif ($this->Identity->get('isManager') == 1) : ?>
                            <!-- View action button for all user authorities -->
                            <a href="<?= $this->Url->buildFromPath('Users::view', [$user->id]) ?>" class="table-link">
                                <span class="fa-stack" data-bs-toggle="tooltip" data-bs-title="View">
                                <i class="fa fa-square fa-stack-2x" style="color:#2B8EC6;"></i>
                                <i class="fa fa-search-plus fa-stack-1x fa-inverse"></i>
                                </span>
                            </a>

                            <!-- Edit and Delete action buttons only for manager and employees -->
                            <?php if ($user->isAdmin == 0) : ?>
                            <a href="<?= $this->Url->buildFromPath('Users::edit', [$user->id]) ?>" class="table-link">
                                <span class="fa-stack" data-bs-toggle="tooltip" data-bs-title="Edit">
                                    <i class="fa fa-square fa-stack-2x" style="color: #2BC6B1;" ></i>
                                    <i class="fa fa-pencil fa-stack-1x fa-inverse"></i>
                                </span>
                            </a>
                            <?= $this->Form->postLink('
                                <span class="fa-stack" data-bs-toggle="tooltip" data-bs-title="Delete">
                                <i class="fa fa-square fa-stack-2x"  style="color: #FF3333;"></i>
                                <i class="fa-solid fa-trash fa-stack-1x" style="color: #ffffff;"></i>
                                </span> ' . __(''), ['action' => 'delete', $user->id], ['escapeTitle' => false, 'confirm' => __("Are you sure you want to delete {0} {1}'s account?", $user->f_name, $user->l_name)]) ?>

                            <?php endif; ?>

                        <?php endif ?>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        
    </div>
</div>
</div>

<script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
jQuery(document).ready(function($) {
    // Initialize the DataTable with responsive settings
    var table = $('#tblContain').DataTable({
        responsive: true,
        paging: true // turn off pages
    });
});

</script>
