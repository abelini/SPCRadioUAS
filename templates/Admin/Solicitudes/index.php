<div class="page-header" style="display: flex; align-items: center; justify-content: space-between;">
    <h5><i class="fa-solid fa-folder-open"></i> Solicitudes</h5>
    <?= $this->Html->link('<i class="fa-solid fa-magnifying-glass"></i> Buscar', ['action' => 'search'], ['class' => 'btn btn-outlined btn-pill', 'escapeTitle' => false, 'style' => 'background: #fff;']) ?>
</div>

<div class="content-card">
    <ul class="solicitudes-list">
        <?php foreach ($solicitudes as $solicitud): ?>
            <?php
            $typeIcon = match ($solicitud->tipoSolicitudID) {
                1 => '<i class="fa-solid fa-file-waveform"></i>',
                2 => '<i class="fa-solid fa-user-tie"></i>',
                3 => '<i class="fa-solid fa-satellite-dish"></i>',
            };
            $typeColor = match ($solicitud->tipoSolicitudID) {
                1 => 'var(--color-cosmic-violet)',
                2 => 'var(--color-vapor-trail-blue)',
                3 => 'var(--color-spring-green)',
            };
            ?>
            <li class="solicitud-item" style="border-left-color: <?= $typeColor ?>;">
                <div class="solicitud-head">
                    <div class="solicitud-icon"><?= $typeIcon ?></div>
                    <div class="solicitud-body">
                        <h4 class="solicitud-title">
                            <?= $this->Html->link(
                                $solicitud->evento,
                                ['action' => 'view', $solicitud->ID],
                                ['escape' => false]
                            ) ?>
                        </h4>
                        <ul class="solicitud-meta">
                            <li style="color: <?= $typeColor ?>;">
                                <i class="fa-solid fa-landmark"></i>
                                <strong><?= h($solicitud->solicitante) ?></strong>
                            </li>
                            <li class="solicitud-id">
                                #<?= $solicitud->ID ?>
                            </li>
                            <li class="solicitud-type" style="color: <?= $typeColor ?>;">
                                <i class="fa-solid fa-tag"></i>
                                <?= $solicitud->tipoSolicitud->name ?>
                            </li>
                        </ul>
                    </div>
                    <div class="solicitud-aside">
                        <div class="solicitud-date-box">
                            <span class="solicitud-date-day"><?= $solicitud->fecha->i18nFormat("d") ?></span>
                            <span class="solicitud-date-my"><?= $solicitud->fecha->i18nFormat("LLL/yy") ?></span>
                            <span class="solicitud-date-time"><?= $solicitud->fecha->i18nFormat("h:mm a") ?></span>
                        </div>
                    </div>
                </div>

                <div class="solicitud-status">
                    <?= $solicitud->getStatus() ?>
                </div>

                <ul class="solicitud-roles">
                    <?php if ($solicitud->tipoSolicitudID == 1): ?>
                        <li>
                            <span class="role-label">Voz asignada</span>
                            <span class="role-name"><?= h($solicitud->primerAsignado->name ?? '-') ?></span>
                        </li>
                        <li>
                            <span class="role-label">Productor técnico</span>
                            <span class="role-name"><?= h($solicitud->productorTecnico->name ?? '-') ?></span>
                        </li>
                    <?php elseif ($solicitud->tipoSolicitudID == 2): ?>
                        <li>
                            <span class="role-label">Maestro de ceremonias</span>
                            <span class="role-name"><?= h($solicitud->primerAsignado->name ?? '-') ?></span>
                        </li>
                        <li>
                            <span class="role-label">Suplente</span>
                            <span class="role-name"><?= h($solicitud->segundoAsignado->name ?? '-') ?></span>
                        </li>
                    <?php elseif ($solicitud->tipoSolicitudID == 3): ?>
                        <li>
                            <span class="role-label">Autoriza</span>
                            <span class="role-name"><?= h($solicitud->autorizante->name ?? '-') ?></span>
                        </li>
                    <?php endif; ?>
                </ul>


            </li>
        <?php endforeach; ?>
    </ul>
</div>

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

<?= $this->Html->link('<i class="fa-solid fa-plus"></i>', ['action' => 'add'], ['class' => 'btn-circle', 'escapeTitle' => false]) ?>