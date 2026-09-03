<?php
/**
 * @var \App\View\AppView $this
 * @var array|null $override
 * @var int $minutesUntilMidnight
 * @var string $defaultPrograma
 * @var string $defaultProduccion
 * @var string $defaultConduccion
 * @var bool $defaultMusic
 * @var string $defaultHoraInicio
 * @var int $defaultDurationMinutes
 * @var int $defaultPty
 * @var string $defaultPtn
 */

use SPC\Enum\PTY;
$this->assign('title', 'Override de Schedule');

?>
<div class="page-header">
    <h5><i class="fa-solid fa-calendar-days"></i> Sobreescribir la programación habitual</h5>
</div>

<?php if ($override !== null): ?>
<div class="alert alert-warning">
    <p>Override activo hasta las <?= date('H:i', $override['expires_at']) ?>
    — <?= $this->Html->link('Cancelar', ['action' => 'override', '?' => ['cancel' => 1]]) ?></p>
</div>
<?php endif; ?>

<div class="form-container">
    <?= $this->Form->create(null, ['url' => ['action' => 'override'], 'type' => 'post']); ?>

    <div class="form-group">
        <?= $this->Form->label('programa', 'Programa') ?>
        <?= $this->Form->control('programa', [
            'type' => 'text',
            'label' => false,
            'value' => $override['programa'] ?? $defaultPrograma,
            'class' => 'form-control',
            'maxlength' => 255,
        ]) ?>
    </div>

    <div class="form-group">
        <?= $this->Form->label('produccion', 'Producción') ?>
        <?= $this->Form->control('produccion', [
            'type' => 'text',
            'label' => false,
            'value' => $override['produccion'] ?? $defaultProduccion,
            'class' => 'form-control',
            'maxlength' => 255,
        ]) ?>
    </div>

    <div class="form-group">
        <?= $this->Form->label('conduccion', 'Conducción') ?>
        <?= $this->Form->control('conduccion', [
            'type' => 'text',
            'label' => false,
            'value' => $override['conduccion'] ?? $defaultConduccion,
            'class' => 'form-control',
            'maxlength' => 255,
        ]) ?>
    </div>

    <div class="form-group">
        <?= $this->Form->label('music', '¿Música?') ?>
        <?= $this->Form->control('music', [
            'type' => 'select',
            'label' => false,
            'options' => [1 => 'Sí', 0 => 'No'],
            'default' => (int)($override['music'] ?? $defaultMusic),
            'class' => 'form-control',
        ]) ?>
    </div>

    <div class="form-group">
        <?= $this->Form->label('pty', 'PTY (Program Type)') ?>
        <?= $this->Form->select('pty', array_column(PTY::cases(), 'name'), ['class' => 'form-control', 'default' => (int)($override['pty'] ?? $defaultPty)]) ?>
    </div>

    <div class="form-group">
        <?= $this->Form->label('ptn', 'PTN (Program Type Name)') ?>
        <?= $this->Form->text('ptn', ['class' => 'form-control', 'maxlength' => 8, 'value' => $override['ptn'] ?? $defaultPtn]) ?>
    </div>

    <div class="form-group">
        <?= $this->Form->label('hora_inicio', 'Hora de inicio') ?>
        <?= $this->Form->control('hora_inicio', [
            'type' => 'time',
            'label' => false,
            'value' => $override['hora_inicio'] ?? $defaultHoraInicio,
            'class' => 'form-control',
        ]) ?>
    </div>

    <div class="form-group">
        <?= $this->Form->label('duration_minutes', 'Duración (minutos)') ?>
        <?= $this->Form->control('duration_minutes', [
            'type' => 'number',
            'label' => false,
            'value' => $minutesUntilMidnight,
            'min' => 1,
            'max' => 10080,
            'class' => 'form-control',
            'id' => 'durationInput',
        ]) ?>
        <small style="color: var(--color-muted-gray)">Default: <?= $minutesUntilMidnight ?> min (hasta medianoche)</small>
    </div>

    <div class="form-group">
        <?= $this->Form->control('until_midnight', [
            'type' => 'checkbox',
            'id' => 'untilMidnight',
            'label' => 'Hasta medianoche',
        ]) ?>
    </div>

    <div class="actions-bar">
        <?= $this->Form->button('<i class="fa-solid fa-check"></i> Aplicar Override', ['class' => 'btn btn-primary', 'escapeTitle' => false]) ?>
        <?php if ($override !== null): ?>
            <?= $this->Html->link('<i class="fa-solid fa-xmark"></i> Cancelar override', ['action' => 'override', '?' => ['cancel' => 1]], ['class' => 'btn btn-outlined', 'escapeTitle' => false]) ?>
        <?php endif; ?>
    </div>

    <?= $this->Form->end() ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var checkbox = document.getElementById('untilMidnight');
    var input = document.getElementById('durationInput');

    function toggleDuration() {
        if (checkbox.checked) {
            input.disabled = true;
            input.value = <?= $minutesUntilMidnight ?>;
        } else {
            input.disabled = false;
        }
    }

    checkbox.addEventListener('change', toggleDuration);
    toggleDuration();
});
</script>
