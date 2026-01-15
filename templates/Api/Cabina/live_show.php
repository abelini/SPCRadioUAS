<div class="w3-container ai-generated-social-content">
    <?= $this->Form->create(null, [
        'id' => 'formAjaxCabina',
        'url' => ['controller' => 'Cabina', 'action' => 'generateSocialContent', 'prefix' => 'Api'],
        'onsubmit' => 'return generateSocialContent(event, this)'
    ]) ?>

    <?= $this->Form->label('programa', 'Programa') ?>
    <?= $this->Form->select(
        'programa',
        $programas->combine('name', 'name')->toArray(),
        [
            'empty' => 'Selecciona un programa',
            'default' => $nextPrograms->first()->name,
            'class' => 'w3-select',
            'id' => 'select-programa',
        ]
    ) ?>
    <?php if ($nextPrograms->first()->isUO): ?>

        <?= $this->Form->label('uo', 'Unidad Organizacional') ?>
        <?= $this->Form->text('uo', [
            'value' => $nextPrograms->first()->UO,
            'class' => 'w3-input',
            'id' => 'input-uo'
        ]) ?>
    <?php endif; ?>

    <?= $this->Form->label('Conducción') ?>
    <?= $this->Form->text('conduccion', [
        'value' => $nextPrograms->first()->conduccion,
        'class' => 'w3-input',
        'id' => 'input-conduccion'
    ]) ?>

    <?= $this->Form->label('Invitados') ?>
    <?= $this->Form->text('invitados', [
        'value' => '',
        'class' => 'w3-input',
        'id' => 'input-invitados'
    ]) ?>

    <?= $this->Form->label('tema', 'Tema a tratar') ?>
    <?= $this->Form->text('tema', [
        'value' => $nextPrograms->first()->tema,
        'class' => 'w3-input',
        'id' => 'input-tema'
    ]) ?>

    <?= $this->Form->hidden('type', [
        'value' => 'liveShow'
    ]) ?>

    <?= $this->Form->submit('Gemini, genérame 3 opciones de publicación para Facebook Live', [
        'class' => 'w3-button w3-blue'
    ]) ?>

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