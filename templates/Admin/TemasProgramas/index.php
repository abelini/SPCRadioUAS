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
                <th>Invitados</th>
                <th>Palabras clave</th>
                <th class="actions">Acciones</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($temasProgramas as $temasPrograma): ?>
                <tr>
                    <td><?= $this->Number->format($temasPrograma->ID) ?></td>
                    <td><?= $temasPrograma->hasValue('programa') ? $this->Html->link($temasPrograma->programa->name, ['action' => 'edit', $temasPrograma->ID]) : '' ?>
                    </td>
                    <td><?= $temasPrograma->tema ?></td>
                    <td><?= $temasPrograma->invitados ?></td>
                    <td><?= $temasPrograma->tags ?></td>
                    <td class="actions">
                        <?= $this->Html->link('<i class="fa-brands fa-openai"></i> <i class="fa-solid fa-arrow-right"></i> <i class="fa-brands fa-facebook"></i>', ['action' => 'generateSocialContent', $temasPrograma->programa->ID], ['escape' => false]) ?>
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