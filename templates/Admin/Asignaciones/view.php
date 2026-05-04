<div class="page-header">
    <h5><i class="fa-solid fa-calendar-check"></i> Asignación #<?= $asignacione->ID ?></h5>
</div>

<div class="content-card">
    <table class="view-table">
        <tr>
            <th>Rol</th>
            <td><?= $asignacione->hasValue('rol') ? $this->Html->link($asignacione->rol->fechaInicio, ['controller' => 'Roles', 'action' => 'view', $asignacione->rol->ID]) : '' ?></td>
        </tr>
        <tr>
            <th>Locutor</th>
            <td><?= $asignacione->hasValue('locutor') ? $this->Html->link($asignacione->locutor->name, ['controller' => 'Locutores', 'action' => 'view', $asignacione->locutor->ID]) : '' ?></td>
        </tr>
        <tr>
            <th>Día</th>
            <td><?= $asignacione->hasValue('dia') ? $this->Html->link($asignacione->dia->name, ['controller' => 'Dias', 'action' => 'view', $asignacione->dia->ID]) : '' ?></td>
        </tr>
        <tr>
            <th>Horario</th>
            <td><?= $asignacione->hasValue('horario') ? $this->Html->link($asignacione->horario->ID, ['controller' => 'Horarios', 'action' => 'view', $asignacione->horario->ID]) : '' ?></td>
        </tr>
        <tr>
            <th>ID</th>
            <td><?= $this->Number->format($asignacione->ID) ?></td>
        </tr>
    </table>

    <div class="actions-bar">
        <?= $this->Html->link('<i class="fa-regular fa-pen-to-square"></i> Modificar', ['action' => 'edit', $asignacione->ID], ['class' => 'btn btn-outlined', 'escapeTitle' => false]) ?>
        <?= $this->Form->deleteLink('<i class="fa-regular fa-trash-can"></i> Eliminar', ['action' => 'delete', $asignacione->ID], ['confirm' => '¿Estás seguro de eliminar esta asignación?', 'class' => 'btn btn-danger', 'escapeTitle' => false]) ?>
    </div>
</div>