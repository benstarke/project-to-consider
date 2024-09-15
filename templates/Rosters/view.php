<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Roster $roster
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Roster'), ['action' => 'edit', $roster->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Roster'), ['action' => 'delete', $roster->id], ['confirm' => __('Are you sure you want to delete # {0}?', $roster->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Rosters'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Roster'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="rosters view content">
            <h3><?= h($roster->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($roster->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($roster->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('End Date') ?></th>
                    <td><?= h($roster->end_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Create Time') ?></th>
                    <td><?= h($roster->create_time) ?></td>
                </tr>
                <tr>
                    <th><?= __('Update Time') ?></th>
                    <td><?= h($roster->update_time) ?></td>
                </tr>
                <tr>
                    <th><?= __('Roster Date') ?></th>
                    <td><?= h($roster->roster_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('IsDefault') ?></th>
                    <td><?= $roster->isDefault ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Shifts') ?></h4>
                <?php if (!empty($roster->shifts)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Start Time') ?></th>
                            <th><?= __('End Time') ?></th>
                            <th><?= __('Image') ?></th>
                            <th><?= __('IsLeaves') ?></th>
                            <th><?= __('Roster Id') ?></th>
                            <th><?= __('Role Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Clock In Time') ?></th>
                            <th><?= __('Clock Out Time') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($roster->shifts as $shift) : ?>
                        <tr>
                            <td><?= h($shift->id) ?></td>
                            <td><?= h($shift->start_time) ?></td>
                            <td><?= h($shift->end_time) ?></td>
                            <td><?= h($shift->image) ?></td>
                            <td><?= h($shift->isLeaves) ?></td>
                            <td><?= h($shift->roster_id) ?></td>
                            <td><?= h($shift->role_id) ?></td>
                            <td><?= h($shift->user_id) ?></td>
                            <td><?= h($shift->clock_in_time) ?></td>
                            <td><?= h($shift->clock_out_time) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Shifts', 'action' => 'view', $shift->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Shifts', 'action' => 'edit', $shift->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Shifts', 'action' => 'delete', $shift->id], ['confirm' => __('Are you sure you want to delete # {0}?', $shift->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
