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
 */

$this->assign('title', 'Override de Schedule');

?>
<style>
.schedule-override-panel {
    max-width: 720px;
    margin: 0 auto 2rem;
}
.override-banner {
    background: #fff3cd;
    border: 1px solid #ffc107;
    border-radius: 6px;
    padding: 12px 16px;
    margin-bottom: 1.5rem;
    font-size: 15px;
    color: #856404;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.override-banner a {
    font-weight: 600;
    text-decoration: none;
    color: #856404;
    text-decoration: underline;
}
.form-group {
    margin-bottom: 1rem;
}
.form-group label {
    display: block;
    font-weight: 600;
    margin-bottom: 4px;
}
.form-group input[type="text"],
.form-group input[type="number"],
.form-group input[type="time"],
.form-group select {
    width: 100%;
    padding: 8px 12px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 14px;
    box-sizing: border-box;
}
.form-group input[type="checkbox"] {
    margin-right: 8px;
}
.form-group .hint {
    font-size: 12px;
    color: #666;
    margin-top: 2px;
}
.btn-primary {
    background: #007bff;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
}
.btn-primary:hover {
    background: #0056b3;
}
.btn-secondary {
    background: #6c757d;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    text-decoration: none;
    display: inline-block;
}
.btn-secondary:hover {
    background: #545b62;
}
</style>

<div class="schedule-override-panel">
    <h1>Override de Schedule</h1>

    <?php if ($override !== null): ?>
    <div class="override-banner">
        <span>Override activo hasta las <?= date('H:i', $override['expires_at']) ?></span>
        <?= $this->Html->link('Cancelar', ['action' => 'override', '?' => ['cancel' => 1]], ['class' => 'btn-secondary']) ?>
    </div>
    <?php endif; ?>

    <?= $this->Form->create(null, ['url' => ['action' => 'override'], 'type' => 'post']); ?>

        <div class="form-group">
            <?= $this->Form->label('programa', 'Programa') ?>
            <?= $this->Form->text('programa', [
                'value' => $override['programa'] ?? $defaultPrograma,
                'class' => 'form-control',
                'maxlength' => 255,
            ]) ?>
        </div>

        <div class="form-group">
            <?= $this->Form->label('produccion', 'Producción') ?>
            <?= $this->Form->text('produccion', [
                'value' => $override['produccion'] ?? $defaultProduccion,
                'class' => 'form-control',
                'maxlength' => 255,
            ]) ?>
        </div>

        <div class="form-group">
            <?= $this->Form->label('conduccion', 'Conducción') ?>
            <?= $this->Form->text('conduccion', [
                'value' => $override['conduccion'] ?? $defaultConduccion,
                'class' => 'form-control',
                'maxlength' => 255,
            ]) ?>
        </div>

        <div class="form-group">
            <?= $this->Form->label('music', '¿Música?') ?>
            <?= $this->Form->select('music', [1 => 'Sí', 0 => 'No'], [
                'class' => 'form-control',
                'default' => (int)($override['music'] ?? $defaultMusic),
            ]) ?>
        </div>

        <div class="form-group">
            <?= $this->Form->label('hora_inicio', 'Hora de inicio') ?>
            <?= $this->Form->control('hora_inicio', [
                'type' => 'time',
                'value' => $override['hora_inicio'] ?? $defaultHoraInicio,
                'class' => 'form-control',
            ]) ?>
        </div>

        <div class="form-group">
            <?= $this->Form->label('duration_minutes', 'Duración (minutos)') ?>
            <?= $this->Form->number('duration_minutes', [
                'value' => $minutesUntilMidnight,
                'min' => 1,
                'max' => 1440,
                'class' => 'form-control',
                'id' => 'durationInput',
            ]) ?>
            <span class="hint">Default: <?= $minutesUntilMidnight ?> min (hasta medianoche)</span>
        </div>

        <div class="form-group">
            <?= $this->Form->checkbox('until_midnight', [
                'id' => 'untilMidnight',
                'label' => 'Hasta medianoche',
            ]) ?>
        </div>

        <div class="form-group">
            <?= $this->Form->button('Aplicar Override', ['class' => 'btn-primary']) ?>
            <?php if ($override !== null): ?>
                <?= $this->Html->link('Cancelar override', ['action' => 'override', '?' => ['cancel' => 1]], ['class' => 'btn-secondary']) ?>
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
