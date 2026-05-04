<div class="page-header">
    <h5><i class="fa-solid fa-radio"></i> Reporte de programa #<?= $reporte->ID ?></h5>
</div>

<div class="content-card">
    <table class="view-table">
        <tr>
            <th>Programa</th>
            <td><?= $reporte->programa->name ?></td>
        </tr>
        <tr>
            <th>Status</th>
            <td><?= $reporte->getStatusText() ?></td>
        </tr>
    </table>
        
    <div class="stats-section">
        <div class="page-header">
            <h5><i class="fa-solid fa-list-check"></i> Bitácora</h5>
        </div>
    
        <table class="view-table">
            <tr>
                <th>Fecha</th>
                <td><?= $reporte->reporte->bitacora->fecha->i18nFormat(\IntlDateFormatter::FULL) ?></td>
            </tr>
            <tr>
                <th>Reporte de cabina</th>
                <td><?= $this->Html->link('RC #' . $reporte->reporte->ID, ['controller' => 'ReportesCabinas', 'action' => 'view', $reporte->reporte->ID]) ?></td>
            </tr>
            <tr>
                <th>Reportado por</th>
                <td><?= $reporte->reporte->locutor ?></td>
            </tr>
            <tr>
                <th>Turno</th>
                <td><?= $reporte->reporte->horaInicio ?> - <?= $reporte->reporte->horaFin ?></td>
            </tr>
        </table>
    </div>

    <div class="actions-bar">
        <?= $this->Html->link('<i class="fa-regular fa-pen-to-square"></i> Modificar', ['action' => 'edit', $reporte->ID], ['class' => 'btn btn-outlined', 'escapeTitle' => false]) ?>
        <?= $this->Form->deleteLink('<i class="fa-regular fa-trash-can"></i> Eliminar', ['action' => 'delete', $reporte->ID], ['confirm' => '¿Estás seguro de eliminar este reporte?', 'class' => 'btn btn-danger', 'escapeTitle' => false]) ?>
    </div>
</div>

