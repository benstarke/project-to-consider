<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */

// $cakeDescription = 'CakePHP: the rapid development php framework';
$pagetitle = 'Clockwork';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?= $pagetitle ?>:
        <?= $this->fetch('title') ?>
    </title>
    <!-- For a .svg favicon -->
    <!-- <?= $this->Html->meta('icon', 'webroot/g20.svg', ['type' => 'image/svg']) ?> -->
    <?php
    // Get the image URL from the ContentBlock->image() method
    $imageTag = $this->ContentBlock->image('browser-logo');

    // Extract the image path from the <img> tag
    preg_match('/src="([^"]+)"/', $imageTag, $matches);
    $imagePath = $matches[1] ?? '';

    // Split the path into an array based on the '/' character
    $parts = explode('/', $imagePath);

    // Remove the first two elements (base path and 'content-blocks') from the array
    // In Server, is 1 and in local host it will be 2 (need to remove 'localhost' too)
    $restOfPath = implode('/', array_slice($parts, 1));

    // Output the rest of the path
    echo $this->Html->meta('icon', $restOfPath, ['type' => 'image/*'])
    ?>
    <!-- Having issues to replace the meta with the image logo stored using ContentBlock -->

    <?= $this->Html->css(['sb-admin-2','sb-admin-2.min','bootstrap','all.min','styles','clockworkcustomized','clockwork']) ?>
    <?= $this->Html->script(['jquery.min','jquery','Chart.min','sb-admin-2.min','scripts']) ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>

<body class="sb-nav-fixed" style=" background-color: aliceblue;" >

<div style="position: relative; z-index: 9999;">
    <?= $this->Flash->render() ?>
</div>

<button class="bg-transparent rounded-circle btn-floating btn-lg" id="btn-back-to-top">
  <i class="fas fa-arrow-up"></i>
</button>
<script>
//Get the button
let mybutton = document.getElementById("btn-back-to-top");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {
  scrollFunction();
};

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    mybutton.style.display = "block";
  } else {
    mybutton.style.display = "none";
  }
}

// When the user clicks on the button, scroll to the top of the document
mybutton.addEventListener('click', function(){
  document.body.scrollTop = 0; // For Safari
  document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
});
</script>
<style>
#btn-back-to-top {
  z-index: 1000; /* This value may need to be higher depending on other elements on your page */
  position: fixed;
  bottom: 80px;
  right: 20px;
  display: none;
}
.body {
        /* padding-top: 20px; */
        background-color: aliceblue;
}

</style>
<nav class="sb-topnav navbar navbar-expand text-primary border border-dark border-2 "  style="background:#A0EEE8">
    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0 text-primary" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>

    <!-- Navbar Brand-->
    <a href="<?= $this->Url->buildFromPath('Pages::index') ?>" class="navbar-brand ps-3" style="white-space: normal;">
        <span style="font-family: Verdana, Geneva, sans-serif;" class="fs-5 fw-semibold ml-3 text-center mt-3 text-primary"><?= $this->ContentBlock->text('website-title'); ?></span>
    </a>
    <!-- Logout Button -->
    <div class="ms-auto me-3">
        <a class="nav-link text-secondary" href="<?= $this->Url->buildFromPath('Auth::logout') ?>" onclick="return confirmLogout()">
            <div class="sb-nav-link-icon"><i class="fa-solid fa-right-to-bracket text-dark"></i> Logout</div>
        </a>
    </div>
</nav>

<div class="position-absolute top-0 end-0 p-2">
        <?= $this->Flash->render() ?>
</div>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion text-primary" id="sidenavAccordion" style='background-image: linear-gradient(to bottom, #A0EEE8, #FFFFFF);'>
                    <div class="sb-sidenav-menu text-primary">
                        <div class="nav">
                        <div class="container text-center mt-2 ">
                        <?= $this->Html->image($this->Identity->get('avatarimg'), ['alt' => 'userprofile', 'class' => 'img-profile card-img-top rounded-circle', 'style' => 'max-width: 75px; max-height: 75px;object-fit: cover;']) ?>
                            <h5 class="card-title"><?= strtoupper($this->Identity->get('f_name')) . ' ' . strtoupper($this->Identity->get('l_name')) ?></h5>
                            <?php if ($this->Identity->get('isAdmin') == 1) : ?>
                                <p class="card-text text-tertiary">nLive Admin</p>
                            <?php elseif ($this->Identity->get('isManager') == 1) : ?>
                                <p class="card-text text-tertiary">Manager</p>
                            <?php else : ?>
                                <p class="card-text text-tertiary">Employee</p>
                            <?php endif; ?>
                        <div class="card-body">
                        </div>
                    </div>
                           <!-- EMPLOYEE VIEW -->
<a class="nav-link text-secondary " href="<?= $this->Url->buildFromPath('Pages::index') ?>">
    <div class="sb-nav-link-icon"><i class="fa-solid fa-sliders text-dark"></i></div>
    Dashboard
</a>
<a class="nav-link text-secondary " href="<?= $this->Url->buildFromPath('Users::profile') ?>">
    <div class="sb-nav-link-icon"><i class="fa-regular fa-user"></i></div>
    Profile
</a>
<a class="nav-link text-secondary " href="<?= $this->Url->build(['controller' => 'LeaveRequests', 'action' => 'index']) ?>">
    <div class="sb-nav-link-icon"><i class="fa-solid fa-calendar-days"></i></div>
    Leave Requests
</a>


                                <!-- MANAGER VIEW -->
                            <?php if ($this->Identity->get('isAdmin') == 1 || $this->Identity->get('isManager') == 1) : ?>
                                <a class="nav-link text-secondary" href="<?= $this->Url->buildFromPath('Rosters::index') ?>">
                                    <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                    Rosters & Shifts
                                </a>
                                <a class="nav-link text-secondary" href="<?= $this->Url->buildFromPath('Tasks::index') ?>">
                                    <div class="sb-nav-link-icon"><i class="fa-solid fa-clipboard-user"></i></div>
                                    Tasks
                                </a>
                                <a class="nav-link text-secondary" href="<?= $this->Url->buildFromPath('Users::index') ?>">
                                    <div class="sb-nav-link-icon"><i class="fas fa-people-group"></i></div>
                                    Employees
                                </a>
                                <a class="nav-link text-secondary" href="<?= $this->Url->buildFromPath('Roles::index') ?>">
                                    <div class="sb-nav-link-icon"><i class="fa-solid fa-list-ul"></i></div>
                                    Roles
                                </a>
                                <a class="nav-link text-secondary" href="<?= $this->Url->buildFromPath('Activities::index') ?>">
                                    <div class="sb-nav-link-icon"><i class="fa-solid fa-vote-yea"></i></div>
                                    Activities
                                </a>
                                
</a>


                            <?php endif; ?>

                            <!-- ADMIN VIEW -->
                            <?php if ($this->Identity->get('isAdmin') == 1) : ?>
                                <a class="nav-link text-secondary " href="<?= $this->Url->buildFromPath('Operations::add') ?>">
                                    <div class="sb-nav-link-icon"><i class="fa-solid fa-business-time"></i></div>
                                    Business Hours
                                </a>
                                <a class="nav-link text-secondary " href="<?= $this->Url->buildFromPath('Logs::index') ?>">
                                    <div class="sb-nav-link-icon"><i class="fa-solid fa-chart-line text-dark"></i></div>
                                    Activity Logs
                                </a>
                                <a class="nav-link text-secondary " href="<?= $this->Url->build(['controller' => 'ContentBlocks', 'action' => 'index', 'plugin' => 'ContentBlocks','escape' => true]) ?>">
                                    <div class="sb-nav-link-icon"><i class="fa-solid fa-gear text-dark"></i></div>
                                    Page Settings
                                </a>
                            <?php endif ?>
                    </div>
                </nav>
            </div>
            <div class="container-fluid " style="font-family:Times;" id="layoutSidenav_content">
                <!-- DataTales Example -->
                <div class="" style="margin-bottom: 70px">
                    <?= $this->fetch('content') ?>
                </div>
            </div>
        </div>
        <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <?= $this->ContentBlock->image('footer-logo', ['style' => 'max-width: 25px; max-height: 25px;']) ?>
                        <span><?= $this->ContentBlock->html('copy-right'); ?></span>
                    </div>
                </div>
        </footer>
</body>
<script>
    function confirmLogout() {
        const confirmAction = confirm('Are you sure you want to logout?');
        if (confirmAction) {
            // Check if a timer exists and clear it
            if (window.timer) {
                clearInterval(window.timer);
                window.timer = null;
            }

            // Reset the local storage or any other state management you are using
            localStorage.removeItem('timerState');

            // Optionally, reset the timer display if it exists on the page
            const timerDisplay = document.getElementById('timerDisplay');
            if (timerDisplay) {
                timerDisplay.textContent = '0 hours 0 minutes 0 seconds';
            }

            // Proceed with logout
            window.location.href = '/logout'; // Adjust this to your logout URL
        }
        return confirmAction;
    }

</script>
</html>

