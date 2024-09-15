<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 * @var \Cake\Collection\CollectionInterface|array<string> $userAvailabilities
 */
$genders = [
    1 => 'Male',
    2 => 'Female',
    3 => 'Non-Binary',
    4 => 'Agender/I don’t identify with any gender',
    5 => 'Prefer not to say',
];

?>

<section class="section profile">
<div class="">
<nav class="bg-light d-flex justify-content-between align-items-center">
    <div class="ml-5 mr-3">
        <h3 class='text-primary'>Employee Management - <?= ($user->f_name) ?>'s Profile</h3>
        <ol class="breadcrumb" style="margin: 0;">
            <li class="breadcrumb-item text-decoration-none"><a href="<?= $this->Url->buildFromPath('Pages::index') ?>" class='text-decoration-none text-info'>Dashboard</a></li>
            <?= $this->Html->link(__('Employees'), ['action' => 'index'], ['class' => 'breadcrumb-item text-info text-decoration-none ']) ?>
            <li class="breadcrumb-item text-decoration-none active"><?= ($user->f_name) ?> <?= ($user->l_name) ?></li>
        </ol>
    </div>
    <a href="#" onclick="window.history.back();" class="'btn btn-secondary btn-sm'">Back</a>
</nav>
<div class="position-absolute top-0 end-0 p-2">
        <?= $this->Flash->render() ?>
    </div>

</div>
<div class="pagetitle ml-3"></div>
    <div class="row text-info">
        <div class="col-xl-4">
            <div class="">
                <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                <!-- Replace with the path for the user's uploaded image -->
                <?php if (empty($user->avatarimg)) : ?>
                    <?= $this->Html->image('userprofile/default.jpeg', ['class' => 'rounded-circle mb-4']); ?>
                <?php else : ?>
                    <?= $this->Html->image($user->avatarimg, ['class' => 'rounded-circle mb-4', 'style' => 'max-width: 200px; max-height: 200px;']); ?>
                <?php endif; ?>
                    <h2><?= strtoupper($user->f_name) ?> <?= strtoupper($user->l_name) ?></h2>
                    <h4><?= $user->email ?></h4>
                </div>
            </div>
        </div>

        <div class="col-xl-8">
        <!-- Right-hand Side Column  -->
            <div class="">
                <div class="card-body pt-3">
                <!-- Bordered Tabs -->

                    <!-- Admin able to view/edit/delete all users -->
                    <?php if ($this->Identity->get('isAdmin') == 1) : ?>
                        <ul class="nav nav-tabs nav-tabs-bordered" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview" aria-selected="true" onclick="$('#profile-overview').show();$('#profile-overview-ava').hide();" role="tab">About</button>
                            </li>
                            <?php if($user->isAdmin != 0 || $user->isManager != 0 || $user->isEmployee != 0) : ?>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link nav-link  text-danger" href="<?= $this->Url->build(['action' => 'edit', $user->id]) ?>">Edit</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <?= $this->Form->postLink(__('Remove'), ['action' => 'delete', $user->id], ['confirm' => __("Are you sure you want to delete {0} {1}'s account?", $user->f_name, $user->l_name), 'class' => 'nav-link  text-danger']) ?>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link nav-link  text-danger"  data-bs-toggle="tab" data-bs-target="#profile-overview-ava" aria-selected="true" role="tab" onclick="$('#profile-overview').hide();$('#profile-overview-ava').show();">Available</button>
                            </li>
                            <?php endif; ?>
                        </ul>

                    <!--
                    Manager only able to delete managers/employees, cannot delete admins
                     Manager can also only edit managers/employees, cannot edit admins
                    -->
                    <?php elseif ($this->Identity->get('isManager') == 1 && $user->isAdmin == 0): ?>
                        <ul class="nav nav-tabs nav-tabs-bordered" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview" aria-selected="true" role="tab">About</button>
                            </li>
                            <?php if($user->isAdmin != 0 || $user->isManager != 0 || $user->isEmployee != 0) : ?>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" href="<?= $this->Url->build(['action' => 'edit', $user->id]) ?>">Edit</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <?= $this->Form->postLink(__('Remove'), ['action' => 'delete', $user->id], ['confirm' => __("Are you sure you want to delete {0} {1}'s account?", $user->f_name, $user->l_name), 'class' => 'nav-link  text-danger']) ?>
                            </li>
                            <?php endif; ?>
                        </ul>
                    <?php elseif ($this->Identity->get('isManager') == 1 && $user->isAdmin == 1): ?>
                        <ul class="nav nav-tabs nav-tabs-bordered" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview" aria-selected="true" role="tab">About</button>
                            </li>
                        </ul>
                    <?php endif ?>
            </div>
        </div>
            <div class="row ml-2">
                <!-- <div class="col-xxl-4 col-md-6">
                    <div class="card info-card revenue-card">
                        <div class="card-body">
                        <h5 class="card-title">Recent Shifts <span></h5>
                        <div class="ps-3">
                        <h6>Date and time start</h6>
                        <span class="text-success small pt-1 fw-bold">Status</span>
                        <span class="text-muted small pt-2 ps-1">locations</span>

                        </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card revenue-card">
                        <div class="card-body">
                        <h5 class="card-title">Recent Activities <span></h5>
                        <div class="ps-3">
                        <h6>Task Done</h6>
                        <span class="text-warning small pt-1 fw-bold">Status 2/5</span>
                        <span class="text-muted small pt-2 ps-1">locations</span>

                        </div>
                        </div>

                    </div>
                </div>
                <div class="col-xxl-4 col-md-6">
                    <div class="card info-card revenue-card">
                        <div class="card-body">
                        <h5 class="card-title">Last Week Hours <span></h5>
                        <div class="ps-3">
                        <h6>Total</h6>
                        <span class="text-danger small pt-1 fw-bold">60 Hours</span>
                        </div>
                        </div>

                    </div>
                </div> -->
            </div>
            <div class="card mt-2 ml-3">
                <div class="ml-3 mt-3 mb-3" id="profile-overview" >
                    <h5 class="card-title">Profile Details</h5>
                    <div class="row">
                        <div class="col-lg-3 col-md-4 label ">Full Name</div>
                        <div class="col-lg-9 col-md-8 text-grey"><?= strtoupper($user->f_name) ?> <?= strtoupper($user->l_name) ?></div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-md-4 label">Email</div>
                        <div class="col-lg-9 col-md-8 text-grey"><?= $user->email ?></div>
                    </div>

                    <!-- Show gender if not null -->
                    <?php if ($user->gender !== null && $user->gender !== 0): ?>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 label">Gender</div>
                            <div class="col-lg-9 col-md-8 text-grey"><?= $genders[$user->gender] ?></div>
                        </div>
                    <?php endif; ?>

                    <!-- Show birthday if not null -->
                    <?php if ($user->birthday !== null): ?>
                        <?php $formattedBirthday = date('d/m/Y', strtotime($user->birthday)); ?>
                        <div class="row">
                            <div class="col-lg-3 col-md-4 label">Birthday</div>
                            <div class="col-lg-9 col-md-8 text-grey"><?= $formattedBirthday ?></div>
                        </div>
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-lg-3 col-md-4 label">Authority Level</div>
                        <?php if ($user->isAdmin == 1) : ?>
                            <div class="col-lg-9 col-md-8 text-grey">nLive Admin</div>
                        <?php elseif ($user->isManager == 1) : ?>
                            <div class="col-lg-9 col-md-8 text-grey">Manager</div>
                               <?php else : ?>
                            <div class="col-lg-9 col-md-8 text-grey">Employee</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="card mt-2 ml-3" id = 'profile-overview-ava' style="display: none">
                <table class="table table-striped">
                    <tr><td>Monday</td><td><?php echo isset($userAvailabilities->monday) ? ($userAvailabilities->monday == true ? 'Available' : 'Unavailable') : '-' ?></td></tr>
                    <tr><td>Tuesday</td><td><?php echo isset($userAvailabilities->tuesday) ? ($userAvailabilities->tuesday == true ? 'Available' : 'Unavailable') : '-' ?></td></tr>
                    <tr><td>Wednesday</td><td><?php echo isset($userAvailabilities->wednesday) ? ($userAvailabilities->wednesday == true ? 'Available' : 'Unavailable') : '-' ?></td></tr>
                    <tr><td>Thursday</td><td><?php echo isset($userAvailabilities->thursday) ? ($userAvailabilities->thursday == true ? 'Available' : 'Unavailable') : '-' ?></td></tr>
                    <tr><td>Friday</td><td><?php echo isset($userAvailabilities->friday) ? ($userAvailabilities->friday == true ? 'Available' : 'Unavailable') : '-' ?></td></tr>
                    <tr><td>Saturday</td><td><?php echo isset($userAvailabilities->saturday) ? ($userAvailabilities->saturday == true ? 'Available' : 'Unavailable') : '-' ?></td></tr>
                    <tr><td>Sunday</td><td><?php echo isset($userAvailabilities->sunday) ? ($userAvailabilities->sunday == true ? 'Available' : 'Unavailable') : '-' ?></td></tr>
                </table>

            </div>
        </div>
      </div>
</section>
