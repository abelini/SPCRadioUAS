<div class="page-header">
    <h5><i class="fa-solid fa-radio"></i> Programas</h5>
</div>

<div class="content-card">
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Logo</th>
                <th>Categoría</th>
                <th>PTY</th>
                <th>PTN</th>
                <th>Horario</th>
                <th>Conducción</th>
                <th>Producción</th>
                <th>Reportable</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($programas as $programa): ?>
                <tr>
                    <td><?= $programa->ID ?></td>
                    <td><span style="display:inline-block;width:10px;height:10px;border-radius:50%;background-color:<?= $programa->outOfAir ? '#e74c3c' : '#2ecc71' ?>;margin-right:6px" title="<?= $programa->outOfAir ? 'Fuera del aire' : 'Al aire' ?>"></span><?= $this->Html->link($programa->name, ['action' => 'edit', $programa->ID]) ?></td>
                    <td><?= $programa->image ? '<i class="fa-regular fa-image"></i>' : '' ?></td>
                    <td><?= $programa->hasValue('categoria') ? $programa->categoria->name : 'Sin categoría' ?></td>
                    <td><?= $programa->pty?->name ?></td>
                    <td><?= h($programa->ptn) ?: '—' ?></td>
                    <td><?= $programa->horaInicio ?> <i class="fa-solid fa-arrow-right-long"></i> <?= $programa->horaFin ?>
                    </td>
                    <td><?= $programa->conduccion ?></td>
                    <td><?= $programa->produccion ?></td>
                    <td><?= $programa->isReportable() ? 'Sí' : 'No' ?></td>
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

<?= $this->Html->link('<i class="fa-solid fa-plus"></i>', ['action' => 'add'], ['class' => 'btn-circle', 'escape' => false]) ?>