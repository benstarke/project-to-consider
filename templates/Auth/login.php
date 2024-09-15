<?php
/**
 * @var \App\View\AppView $this
 */

use Cake\Core\Configure;

$debug = Configure::read('debug');

$this->layout = 'login';
$this->assign('title', 'Login');
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<section class="vh-100">
  <div class="float-right">
  <?= $this->Flash->render() ?>
  </div>
  <div class="container-fluid">
    <div class="row"style="display: flex; align-items: center;">
        <div class="col-sm-6 px-0 d-none d-sm-block text-center">
            <div>
<?= $this->ContentBlock->image('website-logo', ['alt' => 'Log-In', 'class' => 'mb-3', 'style' => 'max-width: 250px; max-height: 250px;']); ?>
            </div>
            <div>
                <span class=" text-gray-900">RMS - Roster Management Systems</span>
            </div>
        </div>

      <div class="col-sm-6 text-black">

        <div class="h-custom-2 px-5 ms-xl-4 mt-5 pt-5 pt-xl-0 mt-xl-n5 text-center">
            <div class="h3  mb-0 me-3 mt-xl-4">Welcome to <?= $this->ContentBlock->text('website-title', ['alt' => 'Log-In', 'class' => 'mb-3']); ?></div>
        </div>
        <div class=" h-custom-2 px-5 ms-xl-4 mt-2 pt-5 pt-xl-0 mt-xl-n5 text-center">
            <div class="h5 text-secondary  mb-0 me-3 " id="day">Sign In</div>
        </div>
        <div class="h-custom-2 px-5 ms-xl-4 mt-5 pt-xl-0 mt-xl-n5">

        <div class="card border-0">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
            <?= $this->Html->image('userprofile/default.jpeg', ['alt' => 'Log-In', 'class' => 'mb-3 rounded-circle']) ?>
            </div>
          </div>
            <?= $this->Form->create(null, ['class' => 'user']) ?>
            <fieldset>

            <div class="form-group">
                <?= $this->Form->control('email', [
                                            'type' => 'email',
                                            'required' => true,
                                            'class' => 'form-control form-control-user text-secondary',
                                            'id' => 'exampleInputEmail',
                                            'aria-describedby' => 'emailHelp',
                                            'value' => $debug ? '' : '',
                ]) ?>
            </div>
            <div class="form-group">
                <?= $this->Form->control('password', [
                                            'type' => 'password',
                                            'required' => true,
                                            'class' => 'form-control form-control-user',
                                            'id' => 'exampleInputPassword',
                                            'value' => $debug ? '' : '',
                ]) ?>
            </div>

            <div class="pt-1 mb-4">
<!--                <div class="form-group text-center">-->
<!--                    <?//= $this->Form->control('remember_me', ['type' => 'checkbox', 'class' => 'ml-3','label' => '  Remember Me']) ?>-->
<!--                </div>-->
            <?= $this->Form->button('Login', ['class' => 'btn btn-info btn-user btn-block']) ?>
            <?= $this->Form->end() ?>
            </div>
            <div class="text-center">
                <?= $this->Html->link('Forgot password?', ['controller' => 'Auth', 'action' => 'forgetPassword'], ['class' => 'button text-muted text-decoration-none']) ?>
            </div>
            </fieldset>

        </div>

      </div>
    </div>
  </div>
</section>
<script>
  // Get current date and time
  var now = new Date();

  // Format the time to HH:MM AM/PM
  var options = { hour: 'numeric', minute: '2-digit', hour12: true };
  var timeString = now.toLocaleString('en-US', options);

  // Insert time into HTML
  document.getElementById("datetime").innerHTML = timeString;
    // Format the date to Day

    var options = { weekday: 'long' };
  var dayString = now.toLocaleString('en-US', options);

  // Insert day into HTML
  document.getElementById("day").innerHTML = dayString;
</script>
