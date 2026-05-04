<div class="page-header">
    <h5><i class="fa-regular fa-pen-to-square"></i> Modificar área: <?= h($area->name) ?></h5>
</div>

<div class="form-container">
    <?= $this->Form->create($area) ?>
    <fieldset>
        <legend><?= __('Edit Area') ?></legend>
        <?php
            echo $this->Form->control('name', ['class' => 'form-control']);
            echo $this->Form->control('icon', ['class' => 'form-control']);
        ?>
    </fieldset>
    <div class="actions-bar">
        <?= $this->Form->button('<i class="fa-solid fa-check"></i> Guardar', ['escapeTitle' => false]) ?>
        <?= $this->Html->link('<i class="fa-solid fa-xmark"></i> Cancelar', ['action' => 'index'], ['class' => 'btn btn-outlined', 'escapeTitle' => false]) ?>
    </div>
    <?= $this->Form->end() ?>
</div>