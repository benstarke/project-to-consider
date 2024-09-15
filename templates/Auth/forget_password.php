<?php
/**
 * @var \App\View\AppView $this
 */

$this->layout = 'login';
$this->assign('title', 'Forget Password');
?>

<!-- <div class="container login">
    <div class="row">
        <div class="column column-50 column-offset-25">

            <div class="users form content">

                <?= $this->Form->create() ?>

                <fieldset>

                    <legend>Forget Password</legend>

                    <?= $this->Flash->render() ?>

                    <p>Enter your email address registered with our system below to reset your password: </p>

                    <?php
                    echo $this->Form->control('email', [
                        'type' => 'email',
                        'required' => true,
                        'autofocus' => true,
                        'label' => false
                    ]);
                    ?>

                </fieldset>

                <?= $this->Form->button('Send verification email') ?>
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
                                        <h1 class="h4 text-gray-900 mb-2">Forgot Your Password?</h1>
                                        <p class="mb-4 text-secondary">We get it, stuff happens. Just enter your email address below
                                            and we'll send you a link to reset your password!</p>
                                    </div>
                                    <?= $this->Form->create(null, ['class' => 'user']) ?>
                                        <fieldset>
                                            <?= $this->Flash->render() ?>
                                            <div class="form-group ">
                                            <?php
                                            echo $this->Form->control('email', [
                                                'type' => 'email',
                                                'required' => true,
                                                'autofocus' => true,
                                                'label' => false,
                                                'class'=> 'form-control form-control-user',
                                                'placeholder'=> 'Enter Your Email Address...',
                                            ]);
                                            ?>
                                            </div>
                                        </fieldset>

                                        <?= $this->Form->button('Reset Password',['class'=> 'btn btn-info btn-user btn-block']) ?>
                                        <?= $this->Form->end() ?>
                                    <hr>
                                    <div class="text-center">
                                        <?= $this->Html->link('Back to login', 
                                        ['controller' => 'Auth', 'action' => 'logout'], 
                                        ['class' => 'button text-info text-decoration-none']
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
