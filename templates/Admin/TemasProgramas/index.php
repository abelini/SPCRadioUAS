<div class="content">
    <div class="page-header">
        <h5>Temas de programas</h5>
    </div>

    <div class="content-card">
        <table class="data-table">
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

        <?= $this->Html->link('<i class="fa-solid fa-plus"></i>', ['action' => 'add'], ['class' => 'btn-circle', 'escape' => false]) ?>
    </div>

</div>