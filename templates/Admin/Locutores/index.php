<div class="page-header">
    <h5><i class="fa-solid fa-user"></i> Locutores</h5>
</div>

<div class="content-card">
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Empleado</th>
                <th>Usuario</th>
                <th>Nombre</th>
                <th>Nombre completo</th>
                <th>Email</th>
                <th>Base</th>
                <th>Foto</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($locutores as $locutore): ?>
                <tr>
                    <td><?= $this->Number->format($locutore->ID) ?></td>
                    <td><?= $this->Number->format($locutore->empleado) ?></td>
                    <td><?= $this->Html->link($locutore->username, ['action' => 'edit', $locutore->ID]) ?></td>
                    <td><?= h($locutore->name) ?></td>
                    <td><?= h($locutore->fullname) ?></td>
                    <td><?= h($locutore->email) ?></td>
                    <td><?= h($locutore->base) ?></td>
                    <td><?= h($locutore->photo) ?></td>
                    <td>
                        <?= $this->Html->link('<i class="fa-solid fa-eye"></i>', ['action' => 'view', $locutore->ID], ['escapeTitle' => false]) ?>
                        <?= $this->Html->link('<i class="fa-regular fa-pen-to-square"></i>', ['action' => 'edit', $locutore->ID], ['escapeTitle' => false]) ?>
                        <?= $this->Form->deleteLink('<i class="fa-regular fa-trash-can"></i>', ['action' => 'delete', $locutore->ID], ['confirm' => '¿Estás seguro de eliminar este locutor?', 'escapeTitle' => false]) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="pagination-counter">
        <?= $this->Paginator->counter('Página {{page}} de {{pages}}, mostrando {{current}} registro(s) de un total de {{count}}') ?>
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