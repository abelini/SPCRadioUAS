<div class="page-header">
    <h5><i class="fa-solid fa-folder-open"></i> Solicitudes</h5>
</div>

<div class="content-card">
    <ul style="list-style: none; padding: 0;">
        <?php foreach ($solicitudes as $solicitud): ?>
            <li style="background-color: var(--surface-floating-card-translucent); border: 1px solid var(--color-subtle-gray); border-radius: var(--radius-cards); padding: var(--spacing-16); margin-bottom: var(--spacing-16);">
                <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                    <div>
                        <h6 style="margin: 0;"><?= $this->Html->link($solicitud->solicitante, ['action' => 'view', $solicitud->ID], ['style' => 'color: var(--color-ghost-white);']) ?></h6>
                        <p style="color: var(--color-faded-silver); margin: var(--spacing-8) 0;"><?= $solicitud->tipoSolicitud ?></p>
                        <p style="margin: 0;"><?= $this->Html->link($solicitud->evento, ['action' => 'view', $solicitud->ID]) ?></p>
                    </div>
                    <div style="text-align: right;">
                        <span style="color: var(--color-ui-gray); font-size: var(--text-caption);">Solicitud #<?= $solicitud->ID ?></span>
                        <p style="margin: var(--spacing-4) 0; color: var(--color-faded-silver);"><?= str_replace(':00 ', '', $solicitud->fecha->i18nFormat("d MMM YYYY, h:mm aaa")) ?></p>
                    </div>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: var(--spacing-12);">
                    <div><?= $solicitud->getStatus() ?></div>
                    <div><?= $solicitud->alreadyAccepted() ?></div>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>

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