<?php $this->assign('title', 'Override de Schedule'); ?>

<div class="page-header">
    <h5><i class="fa-solid fa-calendar-days"></i> Sobreescribir la programación habitual</h5>
</div>

<?php if ($override !== null): ?>
<div class="alert alert-warning">
    <p>Programación habitual pausada hasta el <strong><?= $this->Time->i18nFormat(date:$override['expires_at'], format:$intlFormat, timezone:$timezone) ?></strong>
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
        <?= $this->Form->select('pty', $programTypes, ['class' => 'form-control', 'default' => (int)($override['pty'] ?? $defaultPty)]) ?>
    </div>

    <div class="form-group">
        <?= $this->Form->label('ptn', 'PTN (Program Type Name)') ?>
        <?= $this->Form->text('ptn', ['class' => 'form-control', 'maxlength' => 8, 'value' => $override['ptn'] ?? $defaultPtn]) ?>
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
        <small style="color: var(--color-muted-gray)">
            <ul style="margin: 0 1rem;; padding: 0.5rem 1rem;">
                <li><?= $minutesUntilMidnight ?> min (hasta hoy a las 23:59)</li>
                <li>1440 min (1 día)</li>
                <li>10080 min (7 días)</li>
            </ul>
        </small>
    </div>

    <div class="form-group">
        <?= $this->Form->control('until_midnight', [
            'type' => 'checkbox',
            'id' => 'untilMidnight',
            'label' => ' Hasta medianoche',
        ]) ?>
    </div>

    <div class="actions-bar">
        <?= $this->Form->button('<i class="fa-solid fa-check"></i> Sobreescribir programación', ['class' => 'btn btn-primary', 'escapeTitle' => false]) ?>
        <?php if ($override !== null): ?>
            <?= $this->Html->link('<i class="fa-solid fa-xmark"></i> Cancelar programación', ['action' => 'override', '?' => ['cancel' => 1]], ['class' => 'btn btn-outlined', 'escapeTitle' => false]) ?>
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
