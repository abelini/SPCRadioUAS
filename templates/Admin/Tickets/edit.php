<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Ticket $ticket
 * @var string[]|\Cake\Collection\CollectionInterface $bitacoraVigilancia
 * @var string[]|\Cake\Collection\CollectionInterface $usuarios
 */
?>
<div class="page-header">
    <h5><i class="fa-regular fa-pen-to-square"></i> Modificar ticket</h5>
</div>

<div class="form-container">
    <?= $this->Form->create($ticket) ?>
    <fieldset>
        <legend><?= __('Edit Ticket') ?></legend>
        <?php
            echo $this->Form->control('bitacoraID', ['options' => $bitacoraVigilancia, 'class' => 'form-control']);
            echo $this->Form->control('userID', ['options' => $usuarios, 'class' => 'form-control']);
            echo $this->Form->control('updates', ['class' => 'form-control']);
            echo $this->Form->control('date', ['class' => 'form-control']);
        ?>
    </fieldset>
    <div class="actions-bar">
        <?= $this->Form->button('<i class="fa-solid fa-check"></i> Guardar', ['escapeTitle' => false]) ?>
        <?= $this->Html->link('<i class="fa-solid fa-xmark"></i> Cancelar', ['action' => 'index'], ['class' => 'btn btn-outlined', 'escapeTitle' => false]) ?>
    </div>
    <?= $this->Form->end() ?>
</div>