<div class="content">

    <div class="w3-deep-blue w3-padding">
        <h5><i class="fa-solid fa-table-list"></i> Editar tema del programa <?= $temasPrograma->programa ?></h5>
    </div>


    <?= $this->Form->create($temasPrograma) ?>


    <?php
    echo $this->Form->control('ProgramaID', ['options' => $programas]);
    echo $this->Form->control('tema');
    echo $this->Form->control('invitados');
    ?>
    <?= $this->Form->control('tags', ['label' => 'Palabras clave']) ?>

    <?= $this->Form->button(__('Actualizar'), ['class' => 'w3-section']) ?>

    <?= $this->Form->end() ?>

</div>