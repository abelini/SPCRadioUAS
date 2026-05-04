<div class="page-header">
    <h5><i class="fa-solid fa-folder-open"></i> Solicitud #<?= $solicitud->ID ?> - <?= h($solicitud->solicitante) ?></h5>
</div>

<?php if ($solicitud->cancelado): ?>
    <div style="background-color: rgba(220, 38, 38, 0.2); border: 1px solid #dc2626; color: #fca5a5; padding: var(--spacing-12) var(--spacing-16); border-radius: var(--radius-md); margin-bottom: var(--spacing-16);">
        <i class="fa-solid fa-box-archive"></i> DOCUMENTO CANCELADO
    </div>
<?php endif; ?>

<div class="content-card">
    <table class="view-table">
        <tr>
            <th>UO/UA que solicita</th>
            <td><?= $solicitud->solicitante ?></td>
        </tr>
        <tr>
            <th>Tipo de solicitud</th>
            <td><?= $solicitud->tipoSolicitud->name ?></td>
        </tr>
        <tr>
            <th>Fecha</th>
            <td><?= $solicitud->fecha->i18nFormat(\IntlDateFormatter::LONG) ?></td>
        </tr>
        <tr>
            <th>Estado</th>
            <td><?= $solicitud->status ?></td>
        </tr>
        <tr>
            <th>Primer Asignado</th>
            <td><?= $solicitud->primerAsignado === null ? '' : $solicitud->primerAsignado ?></td>
        </tr>
        <tr>
            <th>Segundo Asignado</th>
            <td><?= $solicitud->segundoAsignado === null ? '' : $solicitud->segundoAsignado ?></td>
        </tr>
        <tr>
            <th>Autorizado por</th>
            <td><?= $solicitud->autorizanteID === null ? '' : $solicitud->autorizante ?></td>
        </tr>
        <tr>
            <th>Productor Técnico</th>
            <td><?= $solicitud->hasValue('productorTecnico') ? $solicitud->productorTecnico : '' ?></td>
        </tr>
        <tr>
            <th>Aceptado</th>
            <td><?= $solicitud->aceptado ? 'Sí' : 'No' ?></td>
        </tr>
        <tr>
            <th>Cancelado</th>
            <td><?= $solicitud->cancelado ? 'Sí' : 'No' ?></td>
        </tr>
    </table>

    <div style="margin-top: var(--spacing-16);">
        <strong style="color: var(--color-ghost-white);">Evento</strong>
        <div style="color: var(--color-faded-silver); margin-top: var(--spacing-8);"><?= $this->Text->autoParagraph(h($solicitud->evento)); ?></div>
    </div>

    <div style="margin-top: var(--spacing-16);">
        <strong style="color: var(--color-ghost-white);">Observaciones</strong>
        <div style="color: var(--color-faded-silver); margin-top: var(--spacing-8);"><?= $this->Text->autoParagraph(h($solicitud->observaciones)); ?></div>
    </div>

    <div style="margin-top: var(--spacing-16);">
        <strong style="color: var(--color-ghost-white);">Reporte Grabación</strong>
        <div style="color: var(--color-faded-silver); margin-top: var(--spacing-8);"><?= $this->Text->autoParagraph(h($solicitud->reporteGrabacion)); ?></div>
    </div>

    <div style="margin-top: var(--spacing-16);">
        <strong style="color: var(--color-ghost-white);">Reporte Programación</strong>
        <div style="color: var(--color-faded-silver); margin-top: var(--spacing-8);"><?= $this->Text->autoParagraph(h($solicitud->reporteProgramacion)); ?></div>
    </div>

    <div class="actions-bar">
        <?= $this->Html->link('<i class="fa-regular fa-pen-to-square"></i> Modificar', ['action' => 'edit', $solicitud->ID], ['class' => 'btn btn-outlined', 'escapeTitle' => false]) ?>

        <?php if ($solicitud->cancelado): ?>
            <?= $this->Form->postLink('<i class="fa-solid fa-boxes-packing"></i> Restaurar', ['action' => 'edit', $solicitud->ID], ['method' => 'PUT', 'data' => ['cancelado' => false], 'class' => 'btn btn-outlined', 'escapeTitle' => false]) ?>
        <?php else: ?>
            <?= $this->Form->postLink('<i class="fa-solid fa-box-archive"></i> Cancelar', ['action' => 'edit', $solicitud->ID], ['method' => 'PUT', 'data' => ['cancelado' => true], 'class' => 'btn btn-outlined', 'escapeTitle' => false]) ?>
        <?php endif; ?>

        <?= $this->Form->deleteLink('<i class="fa-regular fa-trash-can"></i> Eliminar', ['action' => 'delete', $solicitud->ID], ['confirm' => '¿Estás seguro de eliminar esta solicitud?', 'class' => 'btn btn-danger', 'escapeTitle' => false]) ?>
    </div>
</div>