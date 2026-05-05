<div class="page-header">
    <h5><i class="fa-solid fa-chart-bar"></i> Reportes de cabina</h5>
</div>

<div class="content-card">
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Bitácora</th>
                <th>Locutor</th>
                <th>Hora Inicio</th>
                <th>Hora Fin</th>
                <th>Controles</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reportesCabinas as $reporte): ?>
                <tr>
                    <td><?= $this->Number->format($reporte->ID) ?></td>
                    <td><?= $this->Html->link('#' . $reporte->bitacoraID, ['controller' => 'BitacoraCabina', 'action' => 'view', $reporte->bitacoraID]) ?></td>
                    <td><?= $reporte->locutor->name ?></td>
                    <td><?= h($reporte->horaInicio) ?></td>
                    <td><?= h($reporte->horaFin) ?></td>
                    <td><?= $this->Number->format($reporte->controles) ?></td>
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

<?= $this->Html->link('<i class="fa-solid fa-plus"></i>', ['action' => 'add'], ['class' => 'btn-circle', 'escapeTitle' => false]) ?>