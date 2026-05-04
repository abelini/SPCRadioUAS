<div class="content">

    <div class="page-header">
        <h5><i class="fa-solid fa-table-list"></i> Editar tema del programa <?= $temasPrograma->programa ?></h5>
    </div>

    <div class="form-container">
        <?= $this->Form->create($temasPrograma) ?>

        <?= $this->Form->label('Programa') ?>
        <?= $this->Form->control('ProgramaID', ['options' => $programas, 'label' => false]) ?>

        <?= $this->Form->label('Tema') ?>
        <?= $this->Form->control('tema', ['label' => false]) ?>

        <?= $this->Form->label('Invitados') ?>
        <?= $this->Form->control('invitados', ['label' => false]) ?>

        <?= $this->Form->label('Palabras clave') ?>
        <?= $this->Form->control('tags', ['label' => false]) ?>

        <?= $this->Form->button(__('Actualizar'), ['class' => 'btn']) ?>

        <?= $this->Form->end() ?>
    </div>

</div>