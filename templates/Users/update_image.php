<?php
/**
 * @var \App\View\AppView $this
 * @var string[]|\Cake\Collection\CollectionInterface $roles
 */
?>
<div class="row">
    <div class="column column-80">
        <div class="activities form content">
            <?= $this->Form->create($user,['type' => 'file']) ?>
            <fieldset>
                <legend><?= __('Edit Avatar img') ?></legend>
                <?php if($user->avatarimg):?>
                <img src="<?=$this->Url->build($user->avatarimg)?>" width="200px" height="200px">
                <?php endif;?>
                <?php
                echo $this->Form->control('avatarimg',['type' => 'file','accept' => 'image/*']);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
