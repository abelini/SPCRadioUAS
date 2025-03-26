<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Horario $horario
 * @var \Cake\Collection\CollectionInterface|string[] $turnos
 * @var \Cake\Collection\CollectionInterface|string[] $dias
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Horarios'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="horarios form content">
            <?= $this->Form->create($horario) ?>
            <fieldset>
                <legend><?= __('Add Horario') ?></legend>
                <?php
                    echo $this->Form->control('horaInicio');
                    echo $this->Form->control('horaFin');
                    echo $this->Form->control('turnoID', ['options' => $turnos]);
                    echo $this->Form->control('dias._ids', ['options' => $dias]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
