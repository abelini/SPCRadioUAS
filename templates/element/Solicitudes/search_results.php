<?php
$paginatorUrl = ['?' => ['q' => $q]];
?>

<div class="search-meta" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-12);">
    <span style="color: var(--color-faded-silver); font-size: var(--text-body-sm);">
        <i class="fa-solid fa-magnifying-glass"></i>
        Resultados para <strong style="color: var(--color-ghost-white);"><?= h($q) ?></strong>
    </span>
    <span style="color: var(--color-ui-gray); font-size: var(--text-caption);">
        <?= $this->Paginator->counter('{{count}} resultados') ?>
    </span>
</div>

<?php if (count($solicitudes) > 0): ?>
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
        $viewUrl = ['action' => 'view', $solicitud->ID];
        ?>
        <li class="solicitud-item" style="border-left-color: <?= $typeColor ?>;">
            <div class="solicitud-head">
                <div class="solicitud-icon"><?= $typeIcon ?></div>
                <div class="solicitud-body">
                    <h4 class="solicitud-title">
                        <?= $this->Html->link(h($solicitud->evento), $viewUrl) ?>
                    </h4>
                    <ul class="solicitud-meta">
                        <li style="color: <?= $typeColor ?>;">
                            <i class="fa-solid fa-landmark"></i>
                            <strong><?= h($solicitud->solicitante) ?></strong>
                        </li>
                        <li class="solicitud-id">#<?= $solicitud->ID ?></li>
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
        </li>
    <?php endforeach; ?>
</ul>

<div class="pagination" style="margin-top: var(--spacing-16);">
    <?= $this->Paginator->first('<i class="fa-solid fa-angles-left"></i>', ['escape' => false, 'url' => $paginatorUrl]) ?>
    <?= $this->Paginator->prev('<i class="fa-solid fa-angle-left"></i>', ['escape' => false, 'url' => $paginatorUrl]) ?>
    <?= $this->Paginator->numbers(['url' => $paginatorUrl]) ?>
    <?= $this->Paginator->next('<i class="fa-solid fa-angle-right"></i>', ['escape' => false, 'url' => $paginatorUrl]) ?>
    <?= $this->Paginator->last('<i class="fa-solid fa-angles-right"></i>', ['escape' => false, 'url' => $paginatorUrl]) ?>
</div>

<div class="pagination-counter">
    <?= $this->Paginator->counter('Página {{page}} de {{pages}}. Mostrando {{current}} resultados de un total de {{count}}') ?>
</div>
<?php else: ?>
<div style="text-align: center; padding: var(--spacing-32) 0; color: var(--color-ui-gray);">
    <i class="fa-solid fa-search" style="font-size: 32px; display: block; margin-bottom: var(--spacing-12); opacity: 0.5;"></i>
    No se encontraron resultados para <strong><?= h($q) ?></strong>
</div>
<?php endif; ?>

<script>
document.querySelectorAll('.solicitud-title a').forEach(link => {
    link.addEventListener('click', () => {
        sessionStorage.setItem('searchQuery', '<?= h($q) ?>');
    });
});
</script>