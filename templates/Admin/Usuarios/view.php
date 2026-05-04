<div class="page-header">
    <h5><i class="fa-solid fa-users"></i> <?= $usuario->name ?></h5>
</div>

<div class="content-card" style="max-width: 600px;">
    <?= $this->Html->image($usuario->getProfilePictureUrl(), ['style' => 'width: 100%; border-radius: var(--radius-cards) var(--radius-cards) 0 0;']) ?>
    
    <div style="padding: var(--spacing-16);">
        <h2 style="color: var(--color-ghost-white); margin-top: 0;">Información</h2>
        
        <table class="view-table">
            <tr>
                <th>Número de empleado</th>
                <td><?= $usuario->empleado ?></td>
            </tr>
            <tr>
                <th>Nombre completo</th>
                <td><?= $usuario->fullname ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?= $usuario->email ?></td>
            </tr>
        </table>

        <h2 style="color: var(--color-ghost-white);">Alcance</h2>

        <ul style="list-style: none; padding: 0;">
            <?php foreach ($usuario->permisos as $permiso) : ?>
                <li style="color: var(--color-faded-silver); padding: var(--spacing-4) 0;"><?= $permiso->icon ?> <?= $permiso->singular ?></li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="actions-bar">
        <?= $this->Html->link('<i class="fa-regular fa-pen-to-square"></i> Modificar', ['action' => 'edit', $usuario->ID], ['class' => 'btn btn-outlined', 'escapeTitle' => false]) ?>
        <?= $this->Form->deleteLink('<i class="fa-regular fa-trash-can"></i> Eliminar', ['action' => 'delete', $usuario->ID], ['confirm' => '¿Estás seguro de eliminar este usuario?', 'class' => 'btn btn-danger', 'escapeTitle' => false]) ?>
    </div>
</div>