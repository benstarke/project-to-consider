<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Role $role
 */

?>
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.dataTables.css" />
<script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.2/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.dataTables.js"></script>
<?= $this->Html->css(['customisetable']) ?>
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
<div class="rosters index content">
    <div class="">
        <nav class="bg-light d-flex justify-content-between align-items-center">
            <div class="ml-5 mr-3">
                <h3 class='text-primary'><?= __('Roles') ?></h3>
                <ol class="breadcrumb" style="margin: 0;">
                    <li class="breadcrumb-item text-decoration-none"><a href="<?= $this->Url->buildFromPath('Pages::index') ?>" class='text-decoration-none text-info'>Dashboard</a></li>
                    <?= $this->Html->link(__('Roles'), ['action' => 'index'], ['class' => 'breadcrumb-item active text-decoration-none']) ?>
                </ol>
            </div>
            <div>
            <?= $this->Html->link(__('Back'), ['action' => 'index'], ['class' => 'btn btn-secondary btn-sm']) ?>
            </div>
        </nav>
    </div>
    <br>
</div>
<div class="card">
    <div class="card-body" style="min-height: 150px">
        <h3 class="card-title"><?= $role->name?></h3>
        <label for="">Eligible for this role</label>
        <div>
            <span class='ml-2 text-content'>
            &#8226  <?= $role->eligible ?>
            </span>
        </div>
    </div>
</div>
<div class="users index content mt-5 ml-2 mr-2 text-info">
    <div class="table-responsive">
        <h4>Activities For This Role</h4>
    <?php if (!empty($role->activities)) : ?>
        <table id="tblContain" class=" display nowrap" style="width:100%">
            <thead>
                            <th><?= __('Description') ?></th>
                            <th><?= __('IsActive') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
            </thead>
            <tbody class='text-content'>
            <?php foreach ($role->activities as $activities) : ?>
                    <tr>
                            <td>&#8226 <?= h($activities->description) ?></td>
                            <td>
                            <div class="form-check text-left">        
                            <span class="badge <?= $activities->isActive ? 'badge-success' : 'badge-secondary'; ?>"><?= $activities->isActive ? 'Active' : 'Inactive'; ?></span>
                            </div>
                            </td>
                            <td  class='text-left'>
                            <?= $this->Form->postLink('
                                <span class="fa-stack">
                                <i class="fa fa-square fa-stack-2x"  style="color: #FF3333;"></i>
                                <i class="fa-solid fa-trash fa-stack-1x" style="color: #ffffff;"></i>
                                </span> ' . __(''), ['controller' =>'activities','action' => 'delete', $activities->id], ['escapeTitle' => false, 'confirm' => __('Are you sure you want to delete  "{0}"?', $activities->description)]) ?>
                            </td>
                    </tr>

                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</div>

<script>
jQuery(document).ready(function($) {
    $('#tblContain').DataTable({
        responsive: true,

    });
} );
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
