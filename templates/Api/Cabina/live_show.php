<div class="w3-container ai-generated-social-content">

    <h1 class="w3-center" style="font-size:48px;margin:0;"><i class="fa-brands fa-openai" style="color:#000"></i> <i
            class="fa-solid fa-arrow-right" style="color:#ddd"></i> <i class="fa-brands fa-facebook"
            style="color:#1877F2"></i></h1>

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
            'default' => $nextProgram->name,
            'class' => 'w3-select',
            'id' => 'select-programa',
        ]
    ) ?>
    <?php if ($nextProgram->isUO): ?>

        <?= $this->Form->label('uo', 'Unidad Organizacional') ?>
        <?= $this->Form->text('uo', [
            'value' => $nextProgram->UO,
            'class' => 'w3-input',
            'id' => 'input-uo'
        ]) ?>
    <?php endif; ?>

    <?= $this->Form->label('Conducción') ?>
    <?= $this->Form->text('conduccion', [
        'value' => $nextProgram->conduccion,
        'class' => 'w3-input',
        'id' => 'input-conduccion'
    ]) ?>

    <?= $this->Form->label('Invitados') ?>
    <?= $this->Form->text('invitados', [
        'value' => $nextProgram->tema->invitados ?? '',
        'class' => 'w3-input',
        'id' => 'input-invitados'
    ]) ?>

    <?= $this->Form->label('tema', 'Tema a tratar') ?>
    <?= $this->Form->text('tema', [
        'value' => $nextProgram->tema ?? '',
        'class' => 'w3-input',
        'id' => 'input-tema'
    ]) ?>

    <?= $this->Form->hidden('type', [
        'value' => 'live_show'
    ]) ?>

    <?= $this->Form->button('<i class="fa-solid fa-robot"></i> Generar opciones de publicación para Facebook Live', [
        'class' => 'w3-button w3-round w3-galaxy-blue',
        'escapeTitle' => false
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