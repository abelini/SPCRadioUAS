<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\BitacoraVigilancium $bitacoraVigilancium
 * @var \Cake\Collection\CollectionInterface|string[] $vigilantes
 * @var \Cake\Collection\CollectionInterface|string[] $tipoBitacora
 */
?>
<div class="page-header">
    <h5><i class="fa-solid fa-plus"></i> Agregar bitácora de vigilancia</h5>
</div>

<div class="form-container">
    <?= $this->Form->create($bitacoraVigilancium) ?>
    <fieldset>
        <legend><?= __('Add Bitacora Vigilancium') ?></legend>
        <?php
            echo $this->Form->control('vigilanteID', ['options' => $vigilantes, 'class' => 'form-control']);
            echo $this->Form->control('tipoBitacora', ['options' => $tipoBitacora, 'class' => 'form-control']);
            echo $this->Form->control('fecha', ['class' => 'form-control']);
            echo $this->Form->control('observaciones', ['class' => 'form-control']);
        ?>
    </fieldset>
    <div class="actions-bar">
        <?= $this->Form->button('<i class="fa-solid fa-check"></i> Guardar', ['escapeTitle' => false]) ?>
        <?= $this->Html->link('<i class="fa-solid fa-xmark"></i> Cancelar', ['action' => 'index'], ['class' => 'btn btn-outlined', 'escapeTitle' => false]) ?>
    </div>
    <?= $this->Form->end() ?>
</div>