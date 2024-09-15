<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Availability $availability
 * @var string[]|\Cake\Collection\CollectionInterface $users
 */
?>

<div class="position-relative">
    <nav class="bg-light d-flex justify-content-between align-items-center">
        <div class="ml-5 mr-3">
            <h3 class='text-primary'><?= __('Account Management') ?></h3>
            <ol class="breadcrumb" style="margin: 0;">
                <li class="breadcrumb-item text-decoration-none"><a href="<?= $this->Url->buildFromPath('Pages::index') ?>" class='text-decoration-none text-info'>Dashboard</a></li>

                <!-- Only admins and managers should see employees page -->
                <?php if (($this->Identity->get('isAdmin') == 1) || ($this->Identity->get('isManager') == 1)): ?>
                    <?= $this->Html->link(__('Employees'), ['action' => 'index'], ['class' => 'breadcrumb-item text-decoration-none  text-info']) ?>
                <?php endif ?>

                <li class="breadcrumb-item text-decoration-none">
                    <a href="<?= $this->Url->build($this->request->referer()) ?>" class='text-decoration-none text-info'>Edit Profile</a>
                </li>

                <li class="breadcrumb-item text-decoration-none active">Update Availability</li>

            </ol>
        </div>
    </nav>
    <div class="position-absolute top-0 end-0 p-2">
        <?= $this->Flash->render() ?>
    </div>
</div>

<style>
    .availabilities.form.content {
        margin-top: 20px;
        margin-left: 20px;
    }
</style>

<div class="row">
    <div class="column column-80">
        <div class="availabilities form content">
            <?= $this->Form->create($availability) ?>
            <fieldset>
                <legend><?= __('Update Availability') ?></legend>

                <h6 style="font-weight: bold; font-style: italic;">Check the days that are available to work</h6>
                <table style="width: 50%; border: 1px solid #ddd; border-collapse: collapse;">
                    <tr style="background-color: #f2f2f2;">
                        <th style="padding: 10px; border-bottom: 1px solid #ddd; text-align: center;"><?= __('Day') ?></th>
                        <th style="padding: 10px; border-bottom: 1px solid #ddd; text-align: center;"><?= __('Available to Work') ?></th>
                    </tr>
                    <tr>
                        <td style="padding: 10px; border-bottom: 1px solid #ddd; text-align: center;"><?= __('Monday') ?></td>
                        <td style="padding: 10px; border-bottom: 1px solid #ddd; text-align: center">
                            <?= $this->Form->control('monday', [
                                'type' => 'checkbox',
                                'label' => false,
                                'div' => false,
                                'class' => 'availability-checkbox',
                                'style' => $availability->monday ? 'color: green;' : 'color: red;',
                                'style' => 'width: 20px; height: 20px;'
                            ]) ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 10px; border-bottom: 1px solid #ddd; text-align: center;"><?= __('Tuesday') ?></td>
                        <td style="padding: 10px; border-bottom: 1px solid #ddd; text-align: center;">
                            <?= $this->Form->control('tuesday', [
                                'type' => 'checkbox',
                                'label' => false,
                                'div' => false,
                                'class' => 'availability-checkbox',
                                'style' => $availability->tuesday ? 'color: green;' : 'color: red;',
                                'style' => 'width: 20px; height: 20px;'
                            ]) ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 10px; border-bottom: 1px solid #ddd; text-align: center;"><?= __('Wednesday') ?></td>
                        <td style="padding: 10px; border-bottom: 1px solid #ddd; text-align: center;">
                            <?= $this->Form->control('wednesday', [
                                'type' => 'checkbox',
                                'label' => false,
                                'div' => false,
                                'class' => 'availability-checkbox',
                                'style' => $availability->wednesday ? 'color: green;' : 'color: red;',
                                'style' => 'width: 20px; height: 20px;'
                            ]) ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 10px; border-bottom: 1px solid #ddd; text-align: center;"><?= __('Thursday') ?></td>
                        <td style="padding: 10px; border-bottom: 1px solid #ddd; text-align: center;">
                            <?= $this->Form->control('thursday', [
                                'type' => 'checkbox',
                                'label' => false,
                                'div' => false,
                                'class' => 'availability-checkbox',
                                'style' => $availability->thursday ? 'color: green;' : 'color: red;',
                                'style' => 'width: 20px; height: 20px;'
                            ]) ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 10px; border-bottom: 1px solid #ddd; text-align: center;"><?= __('Friday') ?></td>
                        <td style="padding: 10px; border-bottom: 1px solid #ddd; text-align: center;">
                            <?= $this->Form->control('friday', [
                                'type' => 'checkbox',
                                'label' => false,
                                'div' => false,
                                'class' => 'availability-checkbox',
                                'style' => $availability->friday ? 'color: green;' : 'color: red;',
                                'style' => 'width: 20px; height: 20px;'
                            ]) ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 10px; border-bottom: 1px solid #ddd; text-align: center;"><?= __('Saturday') ?></td>
                        <td style="padding: 10px; border-bottom: 1px solid #ddd; text-align: center;">
                            <?= $this->Form->control('saturday', [
                                'type' => 'checkbox',
                                'label' => false,
                                'div' => false,
                                'class' => 'availability-checkbox',
                                'style' => $availability->saturday ? 'color: green;' : 'color: red;',
                                'style' => 'width: 20px; height: 20px;'
                            ]) ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 10px; border-bottom: 1px solid #ddd; text-align: center;"><?= __('Sunday') ?></td>
                        <td style="padding: 10px; border-bottom: 1px solid #ddd; text-align: center;">
                            <?= $this->Form->control('sunday', [
                                'type' => 'checkbox',
                                'label' => false,
                                'div' => false,
                                'class' => 'availability-checkbox',
                                'style' => $availability->sunday ? 'color: green;' : 'color: red;',
                                'style' => 'width: 20px; height: 20px;'
                            ]) ?>
                        </td>
                    </tr>
                </table>
            </fieldset>
            <br>

            <?= $this->Form->button(__('Default'), [
                'type' => 'button',
                'class' => 'btn btn-secondary',
                'onclick' => 'resetDays()',
            ]) ?>

            <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-outline-info']) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
<script>

    function resetDays() {
        // Uncheck all checkboxes by setting their checked property to false
        document.querySelectorAll('.availability-checkbox').forEach(function(checkbox) {
            checkbox.checked = false;
        });
    }
</script>
