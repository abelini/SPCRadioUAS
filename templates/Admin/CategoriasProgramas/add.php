<?php
/**
 * @var \SPC\View\AppView $this
 * @var \SPC\Model\Entity\CategoriasPrograma $categoriasPrograma
 */
?>
<div class="page-header">
    <h5><i class="fa-solid fa-plus"></i> Agregar categoría de programa</h5>
</div>

<div class="form-container">
    <?= $this->Form->create($categoriasPrograma) ?>
    <div class="form-group">
        <?= $this->Form->label('name', 'Nombre') ?>
        <?= $this->Form->control('name', ['label' => false, 'class' => 'form-control']) ?>
    </div>
    <div class="form-group">
        <?= $this->Form->label('slug', 'Slug') ?>
        <?= $this->Form->control('slug', ['label' => false, 'class' => 'form-control']) ?>
    </div>
    <div class="form-group">
        <?= $this->Form->label('icon', 'Icono (FontAwesome)') ?>
        <?= $this->Form->control('icon', ['label' => false, 'class' => 'form-control', 'placeholder' => 'fa-solid fa-music']) ?>
    </div>
    <div class="actions-bar">
        <?= $this->Form->button('<i class="fa-solid fa-check"></i> Guardar', ['escapeTitle' => false]) ?>
        <?= $this->Html->link('<i class="fa-solid fa-xmark"></i> Cancelar', ['action' => 'index'], ['class' => 'btn btn-outlined', 'escapeTitle' => false]) ?>
    </div>
    <?= $this->Form->end() ?>
</div>