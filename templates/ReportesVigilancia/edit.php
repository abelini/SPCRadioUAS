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
            <?= $this->Form->deleteLink(
                __('Delete'),
                ['action' => 'delete', $reportesVigilancium->ID],
                ['confirm' => __('Are you sure you want to delete # {0}?', $reportesVigilancium->ID), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Reportes Vigilancia'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="reportesVigilancia form content">
            <?= $this->Form->create($reportesVigilancium) ?>
            <fieldset>
                <legend><?= __('Edit Reportes Vigilancium') ?></legend>
                <?php
                echo $this->Form->control('bitacoraID');
                echo $this->Form->control('fire');
                echo $this->Form->control('moist');
                echo $this->Form->control('ventilation');
                echo $this->Form->control('locks');
                echo $this->Form->control('blackout');
                echo $this->Form->control('lost_signal');
                echo $this->Form->control('alarm_on');
                echo $this->Form->control('leds');
                echo $this->Form->control('burning_smell');
                echo $this->Form->control('invaded');
                echo $this->Form->control('walls_cracked');
                echo $this->Form->control('antenna_bent');
                echo $this->Form->control('antenna_lights_off');
                echo $this->Form->control('antenna_anchor_bent');
                echo $this->Form->control('blackout_duration');
                echo $this->Form->control('lost_signal_duration');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>