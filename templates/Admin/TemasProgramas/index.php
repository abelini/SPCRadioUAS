<div class="content">
    <div class="w3-deep-blue w3-padding">
        <h5>Temas de programas</h5>
    </div>

    <table class="w3-table w3-table-all ">
        <thead>
            <tr>
                <th>ID</th>
                <th>Programa</th>
                <th>Tema</th>
                <th>Iinvitados</th>
                <th class="actions">Acciones</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($temasProgramas as $temasPrograma): ?>
                <tr>
                    <td><?= $this->Number->format($temasPrograma->ID) ?></td>
                    <td><?= $temasPrograma->hasValue('programa') ? $this->Html->link($temasPrograma->programa->name, ['controller' => 'Programas', 'action' => 'view', $temasPrograma->programa->ID]) : '' ?>
                    </td>
                    <td><?= h($temasPrograma->tema) ?></td>
                    <td><?= h($temasPrograma->invitados) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $temasPrograma->ID]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $temasPrograma->ID]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $temasPrograma->ID],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $temasPrograma->ID),
                            ]
                        ) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?>
        </p>
    </div>

    <?= $this->Html->link('<i class="fa-solid fa-plus"></i>', ['action' => 'add'], ['class' => 'w3-button w3-circle w3-xxlarge w3-golden w3-hover-dark-golden add', 'escape' => false]) ?>

</div>