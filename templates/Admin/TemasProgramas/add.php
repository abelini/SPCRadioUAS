<div class="content">

    <div class="page-header">
        <h5><i class="fa-solid fa-table-list"></i> Agregar un tema para programa</h5>
    </div>

    <div class="form-container">
        <?= $this->Form->create($temasPrograma) ?>

        <?= $this->Form->control('ProgramaID', ['options' => $programas, 'label' => 'Programa']) ?>

        <?= $this->Form->control('tema', ['label' => 'Tema']) ?>

        <?= $this->Form->control('invitados', ['label' => 'Invitados']) ?>

        <?= $this->Form->control('tags', ['label' => 'Palabras clave']) ?>

        <?= $this->Form->button(__('Agregar'), ['class' => 'btn']) ?>

        <?= $this->Form->end() ?>
    </div>
</div>