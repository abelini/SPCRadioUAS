<div class="page-header">
    <h5><i class="fa-solid fa-list-check"></i> Bitácora #<?= $bitacora->ID ?> - <?= $bitacora->fecha->i18nFormat(\IntlDateFormatter::FULL) ?></h5>
</div>

<div class="content-card">
    <?php if (!empty($bitacora->reportes)): ?>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Reporte</th>
                    <th>Operador</th>
                    <th>Turno</th>
                    <th>CR</th>
                    <th>Reporte de enlaces remotos</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bitacora->reportes as $rc): ?>
                    <tr>
                        <td>#<?= $rc->ID ?></td>
                        <td><?= $rc->locutor ?></td>
                        <td><?= $rc->horaInicio ?> a <?= $rc->horaFin ?></td>
                        <td><?= $rc->controles ?></td>
                        <td><?= $rc->getPrintableReport() ?></td>
                        <td>
                            <?= $this->Html->link('<i class="fa-solid fa-eye"></i>', ['controller' => 'ReportesCabinas', 'action' => 'view', $rc->ID], ['escapeTitle' => false]) ?>
                            <?= $this->Html->link('<i class="fa-regular fa-pen-to-square"></i>', ['controller' => 'ReportesCabinas', 'action' => 'edit', $rc->ID], ['escapeTitle' => false]) ?>
                            <?= $this->Form->deleteLink('<i class="fa-regular fa-trash-can"></i>', ['controller' => 'ReportesCabinas', 'action' => 'delete', $rc->ID], ['confirm' => '¿Estás seguro?', 'escapeTitle' => false]) ?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td class="picture">
                            <?= $this->Html->image($rc->locutor->photo, ['class' => 'img-small img-border']) ?>
                        </td>
                        <td colspan="3">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>Reportes de programas</th>
                                        <th>Programa</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($rc->reportes_programas as $reportePrograma): ?>
                                        <tr>
                                            <td>#<?= $reportePrograma->ID ?></td>
                                            <td><i class="fa-solid fa-radio"></i>
                                                <?= $this->Html->link($reportePrograma->programa ?? 'Unknown', ['controller' => 'Programas', 'action' => 'view', $reportePrograma->programa->ID]) ?>
                                            </td>
                                            <td><?= $reportePrograma->getStatusText(icons: true) ?></td>
                                            <td>
                                                <?= $this->Html->link('<i class="fa-regular fa-pen-to-square"></i>', ['controller' => 'ReportesProgramas', 'action' => 'edit', $reportePrograma->ID], ['escapeTitle' => false]) ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </td>
                        <td>
                            <?= $this->Html->link('<i class="fa-solid fa-file-circle-plus"></i> Agregar', ['controller' => 'ReportesProgramas', 'action' => 'addMissing', $rc->ID], ['escapeTitle' => false, 'class' => 'btn btn-outlined']) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<style>
    td.picture {
        vertical-align: middle !important;
    }

    .img-small {
        width: 80px;
        padding: 4px;
    }

    .img-border {
        border: 1px solid var(--color-subtle-gray);
        border-radius: var(--radius-md);
    }
</style>