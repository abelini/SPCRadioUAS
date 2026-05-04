<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TipoBitacora $tipoBitacora
 */
?>
<div class="page-header">
    <h5><i class="fa-solid fa-plus"></i> Agregar tipo de bitácora</h5>
</div>

<div class="form-container">
    <?= $this->Form->create($tipoBitacora) ?>
    <fieldset>
        <legend><?= __('Add Tipo Bitacora') ?></legend>
        <?php
            echo $this->Form->control('name', ['class' => 'form-control']);
            echo $this->Form->control('turnos', ['class' => 'form-control']);
        ?>
    </fieldset>
    <div class="actions-bar">
        <?= $this->Form->button('<i class="fa-solid fa-check"></i> Guardar', ['escapeTitle' => false]) ?>
        <?= $this->Html->link('<i class="fa-solid fa-xmark"></i> Cancelar', ['action' => 'index'], ['class' => 'btn btn-outlined', 'escapeTitle' => false]) ?>
    </div>
    <?= $this->Form->end() ?>
</div>