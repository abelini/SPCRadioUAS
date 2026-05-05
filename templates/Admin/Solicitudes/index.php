<div class="page-header">
    <h5><i class="fa-solid fa-folder-open"></i> Solicitudes</h5>
</div>

<div class="stats-grid" style="grid-template-columns: 1fr;">
    <?php foreach ($solicitudes as $solicitud): ?>
        <?php
        $typeIcon = match ($solicitud->tipoSolicitudID) {
            1 => '<i class="fa-solid fa-file-waveform"></i>',
            2 => '<i class="fa-solid fa-satellite-dish"></i>',
            3 => '<i class="fa-solid fa-user-tie"></i>',
            default => '<i class="fa-solid fa-file-lines"></i>'
        };
        $typeColor = match ($solicitud->tipoSolicitudID) {
            1 => 'var(--color-cosmic-violet)',
            2 => 'var(--color-vapor-trail-blue)',
            3 => 'var(--color-spring-green)',
            default => 'var(--color-ui-gray)'
        };
        ?>
        <div class="stats-section" style="margin-bottom: var(--spacing-16); border-left:8px solid <?= $typeColor ?>;">
            <div style="display: grid; grid-template-columns: auto 1fr auto; gap: var(--spacing-20); align-items: start;">
                <div style="font-size: 64px;">
                    <?= $typeIcon ?>
                </div>
                <div>
                    <?= $this->Html->link(
                        '<h4 style="margin: 0 0 var(--spacing-4) 0; color: var(--color-ghost-white);">' . h($solicitud->evento) . '</h4>',
                        ['action' => 'view', $solicitud->ID],
                        ['escape' => false]
                    ) ?>
                    <div style="display: flex; gap: var(--spacing-20);">
                        <span style="color:<?= $typeColor ?>;"><i class="fa-solid fa-landmark"></i>
                            <strong><?= h($solicitud->solicitante) ?></strong></span>
                        <span style="color: var(--color-polar-blue);"><i class="fa-regular fa-calendar"></i>
                            <?= $solicitud->fecha->i18nFormat("d MMM YYYY, h:mm a") ?></span>
                    </div>
                </div>
                <div style="text-align: right;">
                    <span
                        style="color: var(--color-faded-silver); font-size: var(--text-heading-sm); font-weight: var(--font-weight-bold);">#<?= $solicitud->ID ?></span>
                    <div style="margin-top: var(--spacing-8);">
                        <span
                            style="color: <?= $typeColor ?>; font-size: var(--text-body-sm); font-weight: var(--font-weight-semibold);">
                            <?= $solicitud->tipoSolicitud->name ?>
                        </span>
                    </div>
                </div>
            </div>

            <div
                style="display: grid; grid-template-columns: repeat(4, 1fr); gap: var(--spacing-12); margin-top: var(--spacing-16); padding-top: var(--spacing-16); border-top: 1px solid var(--color-subtle-gray);">
                <div style="text-align: center;">
                    <div
                        style="color: var(--color-ui-gray); font-size: var(--text-caption); margin-bottom: var(--spacing-4);">
                        1er Locutor</div>
                    <div style="color: var(--color-faded-silver);"><?= h($solicitud->primerAsignado->name ?? '-') ?></div>
                </div>
                <div style="text-align: center;">
                    <div
                        style="color: var(--color-ui-gray); font-size: var(--text-caption); margin-bottom: var(--spacing-4);">
                        2do Locutor</div>
                    <div style="color: var(--color-faded-silver);"><?= h($solicitud->segundoAsignado->name ?? '-') ?></div>
                </div>
                <div style="text-align: center;">
                    <div
                        style="color: var(--color-ui-gray); font-size: var(--text-caption); margin-bottom: var(--spacing-4);">
                        Autoriza</div>
                    <div style="color: var(--color-faded-silver);"><?= h($solicitud->autorizante->name ?? '-') ?></div>
                </div>
                <div style="text-align: center;">
                    <div
                        style="color: var(--color-ui-gray); font-size: var(--text-caption); margin-bottom: var(--spacing-4);">
                        Productor</div>
                    <div style="color: var(--color-faded-silver);"><?= h($solicitud->productorTecnico->name ?? '-') ?></div>
                </div>
            </div>

            <div style="display: flex; justify-content: space-between; align-items: center; margin-top: var(--spacing-16);">
                <div>
                    <?php if ($solicitud->tipoSolicitudID == 1): ?>
                        <?= $solicitud->getStatus() ?>
                    <?php endif; ?>
                </div>
                <div>
                    <?php if (in_array($solicitud->tipoSolicitudID, [1, 2])): ?>
                        <?= $solicitud->aceptado
                            ? '<span style="color: var(--color-spring-green);"><i class="fa-solid fa-check-circle"></i> Aceptado</span>'
                            : '<span style="color: #fca5a5;"><i class="fa-solid fa-circle-xmark"></i> Pendiente</span>'
                            ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<div class="pagination-counter">
    <?= $this->Paginator->counter('Página {{page}} de {{pages}}. Mostrando {{current}} resultados de un total de {{count}}') ?>
</div>

<div class="pagination">
    <?= $this->Paginator->first('<i class="fa-solid fa-angles-left"></i>', ['escape' => false]) ?>
    <?= $this->Paginator->prev('<i class="fa-solid fa-angle-left"></i>', ['escape' => false]) ?>
    <?= $this->Paginator->numbers() ?>
    <?= $this->Paginator->next('<i class="fa-solid fa-angle-right"></i>', ['escape' => false]) ?>
    <?= $this->Paginator->last('<i class="fa-solid fa-angles-right"></i>', ['escape' => false]) ?>
</div>

<?= $this->Html->link('<i class="fa-solid fa-plus"></i>', ['action' => 'add'], ['class' => 'btn-circle', 'escapeTitle' => false]) ?>