<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Availability $availability
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Availability'), ['action' => 'edit', $availability->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Availability'), ['action' => 'delete', $availability->id], ['confirm' => __('Are you sure you want to delete # {0}?', $availability->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Availabilities'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Availability'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>

    <div class="column column-80">
        <div class="availabilities view content">
            <h3><?= h($availability->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('User') ?></th>
                    <td>
                        <?php
                        if ($availability->hasValue('user')) {
                            $linkTitle = $availability->user->f_name ?? 'Unknown';
                            echo $this->Html->link($linkTitle, ['controller' => 'Users', 'action' => 'view', $availability->user->id]);
                        } else {
                            echo '';
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($availability->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Monday') ?></th>
                    <td><?= $availability->monday ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Tuesday') ?></th>
                    <td><?= $availability->tuesday ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Wednesday') ?></th>
                    <td><?= $availability->wednesday ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Thursday') ?></th>
                    <td><?= $availability->thursday ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Friday') ?></th>
                    <td><?= $availability->friday ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Saturday') ?></th>
                    <td><?= $availability->saturday ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Sunday') ?></th>
                    <td><?= $availability->sunday ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
