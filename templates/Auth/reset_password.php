<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */

$this->layout = 'login';
$this->assign('title', 'Reset Password');
?>
<!-- <div class="container login">
    <div class="row">
        <div class="column column-50 column-offset-25">

            <div class="users form content">

                <?= $this->Form->create($user) ?>

                <fieldset>

                    <legend>Reset Your Password</legend>

                    <?= $this->Flash->render() ?>

                    <?php
                    echo $this->Form->control('password', [
                        'type' => 'password',
                        'label' => 'New Password',
                        'required' => true,
                        'autofocus' => true,
                        'value' => '',
                    ]);

                    ?>

                </fieldset>

                <?= $this->Form->button('Reset Password') ?>
                <?= $this->Form->end() ?>

                <hr class="hr-between-buttons">

                <?= $this->Html->link('Back to login', ['controller' => 'Auth', 'action' => 'login'], ['class' => 'button button-outline']) ?>

            </div>
        </div>
    </div>
</div> -->
<div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <?= $this->Html->image('assets/forgetpassword.png', ['alt' => 'ForgetPassword','class' => 'col-lg-6 d-none d-lg-block mb-4 mt-4']); ?>

                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-2">Reset Your Password</h1>
                                    </div>
                                    <?= $this->Form->create(null, ['class' => 'user']) ?>
                                        <fieldset>
                                            <?= $this->Flash->render() ?>
                                            <div class="form-group ">
                                                <label>New Password </a></label>
                                            <?=
                                                 $this->Form->control('password', [
                                                    'type' => 'password',
                                                    'required' => true,
                                                    'autofocus' => true,
                                                    'label' => false,
                                                    'value' => '',
                                                    'class' => 'form-control form-control-user text-bold',
                                                 ]);
                                                    ?>
                                        </fieldset>

                                        <?= $this->Form->button('Reset Password', ['class' => 'btn btn-primary btn-user btn-block']) ?>
                                        <?= $this->Form->end() ?>
                                    <hr>
                                    <div class="text-center">
                                        <?= $this->Html->link(
                                            'Back to login',
                                            ['controller' => 'Auth', 'action' => 'login'],
                                            ['class' => 'button button-outline text-decoration-none']
                                        ) ?>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
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
