<div class="content">

    <div class="w3-deep-blue w3-padding">
        <h5><i class="fa-solid fa-table-list"></i> Agregar un tema para programa</h5>
    </div>

    <?= $this->Form->create($temasPrograma) ?>

    <?= $this->Form->control('ProgramaID', ['options' => $programas, 'label' => 'Programa']) ?>

    <?= $this->Form->control('tema', ['label' => 'Tema']) ?>

    <?= $this->Form->control('invitados', ['label' => 'Invitados']) ?>

    <?= $this->Form->control('tags', ['label' => 'Palabras clave']) ?>

    <?= $this->Form->button(__('Agregar'), ['class' => 'w3-section']) ?>

    <?= $this->Form->end() ?>
</div>