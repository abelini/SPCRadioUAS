<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $reportesVigilancium
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Reportes Vigilancium'), ['action' => 'edit', $reportesVigilancium->ID], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Reportes Vigilancium'), ['action' => 'delete', $reportesVigilancium->ID], ['confirm' => __('Are you sure you want to delete # {0}?', $reportesVigilancium->ID), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Reportes Vigilancia'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Reportes Vigilancium'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="reportesVigilancia view content">
            <h3><?= h($reportesVigilancium->ID) ?></h3>
            <table>
                <tr>
                    <th><?= __('ID') ?></th>
                    <td><?= $this->Number->format($reportesVigilancium->ID) ?></td>
                </tr>
                <tr>
                    <th><?= __('BitacoraID') ?></th>
                    <td><?= $this->Number->format($reportesVigilancium->bitacoraID) ?></td>
                </tr>
                <tr>
                    <th><?= __('Blackout Duration') ?></th>
                    <td><?= $reportesVigilancium->blackout_duration === null ? '' : $this->Number->format($reportesVigilancium->blackout_duration) ?></td>
                </tr>
                <tr>
                    <th><?= __('Lost Signal Duration') ?></th>
                    <td><?= $reportesVigilancium->lost_signal_duration === null ? '' : $this->Number->format($reportesVigilancium->lost_signal_duration) ?></td>
                </tr>
                <tr>
                    <th><?= __('Fire') ?></th>
                    <td><?= $reportesVigilancium->fire ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Moist') ?></th>
                    <td><?= $reportesVigilancium->moist ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Ventilation') ?></th>
                    <td><?= $reportesVigilancium->ventilation ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Locks') ?></th>
                    <td><?= $reportesVigilancium->locks ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Blackout') ?></th>
                    <td><?= $reportesVigilancium->blackout ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Lost Signal') ?></th>
                    <td><?= $reportesVigilancium->lost_signal ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Alarm On') ?></th>
                    <td><?= $reportesVigilancium->alarm_on ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Leds') ?></th>
                    <td><?= $reportesVigilancium->leds ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Burning Smell') ?></th>
                    <td><?= $reportesVigilancium->burning_smell ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Invaded') ?></th>
                    <td><?= $reportesVigilancium->invaded ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Walls Cracked') ?></th>
                    <td><?= $reportesVigilancium->walls_cracked ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Antenna Bent') ?></th>
                    <td><?= $reportesVigilancium->antenna_bent ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Antenna Lights Off') ?></th>
                    <td><?= $reportesVigilancium->antenna_lights_off ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Antenna Anchor Bent') ?></th>
                    <td><?= $reportesVigilancium->antenna_anchor_bent ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
