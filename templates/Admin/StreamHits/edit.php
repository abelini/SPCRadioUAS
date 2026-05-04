<?php
/**
 * @var \SPC\View\AppView $this
 * @var \SPC\Model\Entity\StreamHit $streamHit
 */
?>
<div class="page-header">
    <h5><i class="fa-regular fa-pen-to-square"></i> Modificar stream hit</h5>
</div>

<div class="form-container">
    <?= $this->Form->create($streamHit) ?>
    <fieldset>
        <legend><?= __('Edit Stream Hit') ?></legend>
        <?php
            echo $this->Form->control('format', ['class' => 'form-control']);
            echo $this->Form->control('referer', ['class' => 'form-control']);
            echo $this->Form->control('refererType', ['class' => 'form-control']);
            echo $this->Form->control('ip', ['class' => 'form-control']);
            echo $this->Form->control('userAgent', ['class' => 'form-control']);
            echo $this->Form->control('country', ['class' => 'form-control']);
            echo $this->Form->control('countryCode', ['class' => 'form-control']);
            echo $this->Form->control('city', ['class' => 'form-control']);
            echo $this->Form->control('zip', ['class' => 'form-control']);
            echo $this->Form->control('lat', ['class' => 'form-control']);
            echo $this->Form->control('lon', ['class' => 'form-control']);
        ?>
    </fieldset>
    <div class="actions-bar">
        <?= $this->Form->button('<i class="fa-solid fa-check"></i> Guardar', ['escapeTitle' => false]) ?>
        <?= $this->Html->link('<i class="fa-solid fa-xmark"></i> Cancelar', ['action' => 'index'], ['class' => 'btn btn-outlined', 'escapeTitle' => false]) ?>
    </div>
    <?= $this->Form->end() ?>
</div>