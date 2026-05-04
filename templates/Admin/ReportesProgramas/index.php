<div class="page-header">
    <h5><i class="fa-solid fa-radio"></i> Reportes de programas</h5>
</div>

<div class="content-card">
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Reporte de Cabina</th>
                <th>Programa</th>
                <th>Status</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reportesProgramas as $reporte): ?>
                <tr>
                    <td><?= $this->Number->format($reporte->ID) ?></td>
                    <td><?= $reporte->hasValue('reporte') ? $this->Html->link('#' . $reporte->reporte->ID, ['controller' => 'ReportesCabinas', 'action' => 'view', $reporte->reporte->ID]) : '' ?>
                    </td>
                    <td><?= $reporte->hasValue('programa') ? $this->Html->link($reporte->programa->name, ['controller' => 'Programas', 'action' => 'view', $reporte->programa->ID]) : '' ?>
                    </td>
                    <td><?= h($reporte->status) ?></td>
                    <td>
                        <?= $this->Html->link('<i class="fa-solid fa-eye"></i>', ['action' => 'view', $reporte->ID], ['escapeTitle' => false]) ?>
                        <?= $this->Html->link('<i class="fa-regular fa-pen-to-square"></i>', ['action' => 'edit', $reporte->ID], ['escapeTitle' => false]) ?>
                        <?= $this->Form->deleteLink('<i class="fa-regular fa-trash-can"></i>', ['action' => 'delete', $reporte->ID], ['confirm' => '¿Estás seguro?', 'escapeTitle' => false]) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

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
</div>

<?= $this->Html->link('<i class="fa-solid fa-plus"></i> Agregar', ['action' => 'add'], ['class' => 'btn-circle', 'escapeTitle' => false]) ?>