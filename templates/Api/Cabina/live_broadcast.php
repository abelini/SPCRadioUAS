<div class="w3-container ai-generated-social-content">
    <?= $this->Form->create(null, [
        'id' => 'formAjaxCabina',
        'url' => ['controller' => 'Cabina', 'action' => 'generateSocialContent', 'prefix' => 'Api'],
        'onsubmit' => 'return generateSocialContent(event, this)'
    ]) ?>


    <?= $this->Form->label('evento', 'Nombre del evento') ?>
    <?= $this->Form->text('evento', ['value' => '', 'placeholder' => 'Ej. Firma de convenio de colaboración entre...', 'class' => 'w3-input']) ?>

    <?= $this->Form->label('evento', 'Participantes (opcional)') ?>
    <?= $this->Form->text('participantes', ['value' => '', 'placeholder' => 'Ej. Rector Dr. Jesús Madueña Molina y autoridades de la Facultad de...', 'class' => 'w3-input']) ?>

    <?= $this->Form->hidden('type', ['value' => 'liveBroadcast']) ?>

    <?= $this->Form->submit('Gemini, genérame 3 opciones de publicación para Facebook Live', ['class' => 'w3-button w3-blue']) ?>

    <?= $this->Form->end() ?>
</div>

<div id="ai-generated-social-content"></div>

<style>
    .ai-generated-social-content select,
    .ai-generated-social-content input,
    .ai-generated-social-content submit {
        margin: 4px 0 16px;
    }

    .ai-generated-social-content h1 {
        font-family: "Barlow Semi Condensed", sans-serif;
        font-weight: 400;
        font-size: 17px;
        font-style: normal;
    }
</style>