<div class="page-header">
    <h5 style="text-align: center;"><i class="fa-solid fa-calendar-week"></i> Semana del <?= $starts->i18nFormat("EEEE d 'de' MMMM")?> al <?= $starts->next(7)->i18nFormat("EEEE d 'de' MMMM 'de' YYYY")?></h5>
</div>

<?php $x =0; ?>

<?php foreach($turno as $dia) : ?>
    <div class="stats-section">
        <div class="page-header">
            <h6><?= $dia->name ?> <?= $starts->addDays($offset++)->i18nFormat("d 'de' MMMM")?></h6>
        </div>
        <div class="content-card">
            <div style="display: grid; grid-template-columns: repeat(<?= count($dia->horarios) ?>, 1fr); gap: var(--spacing-16);">
                <?php foreach($dia->horarios as $horario) : ?>
                    <div>
                        <div style="background-color: var(--surface-code-canvas); padding: var(--spacing-12); border-radius: var(--radius-cards) var(--radius-cards) 0 0; text-align: center;">
                            <h6 style="color: var(--color-ghost-white); margin: 0;"><i class="fa-regular fa-clock"></i> <?= $horario->horaInicio ?> - <?= $horario->horaFin?></h6>
                        </div>
                        <div style="padding: var(--spacing-8);">
                            <?= $this->Form->select('asignaciones.'.$x.'.locutorID', $locutores, ['size' => count($locutores), 'class' => 'form-control'])?>
                        </div>
                        <?= $this->Form->hidden('asignaciones.'.$x.'.rolID'])?>
                        <?= $this->Form->hidden('asignaciones.'.$x.'.diaID', ['value' => $dia->ID])?>
                        <?= $this->Form->hidden('asignaciones.'.$x.'.horarioID', ['value' => $horario->ID])?>
                    </div>
                    <?php $x++; ?>
                <?php endforeach;?>
            </div>
        </div>
    </div>
<?php endforeach; ?>