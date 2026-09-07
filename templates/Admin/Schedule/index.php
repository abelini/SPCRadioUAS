<?php $this->assign('title', 'Programación semanal'); ?>

<div class="page-header">
    <h5><i class="fa-solid fa-calendar-days"></i> Programación <i class="fa-solid fa-chevron-right"></i> <?= h($dayNames[$activeDay]) ?></h5>
</div>

<div class="content-card">
    <div class="schedule-toolbar">
        <nav class="schedule-tabs">
            <?php for ($d = 1; $d <= 7; $d++): ?>
                <?= $this->Html->link(
                    $dayNames[$d],
                    ['action' => 'index', '?' => ['day' => $d]],
                    ['class' => 'schedule-tab' . ($d === $activeDay ? ' active' : '')]
                ) ?>
            <?php endfor; ?>
        </nav>

        <div class="schedule-actions">
            <?php if (!$overrideActive): ?>
                <?= $this->Html->link('<i class="fa-solid fa-pen"></i> Activar programación', ['action' => 'override'], ['class' => 'btn btn-outlined', 'escapeTitle' => false]) ?>
            <?php endif; ?>
        </div>
    </div>

    <?php if ($overrideActive): ?>
        <div class="alert alert-danger">
            <p><i class="fa-solid fa-triangle-exclamation"></i> Actualmente la programación está siendo sobreescrita. <?= $this->Html->link('Ver más <i class="fa-solid fa-up-right-from-square"></i>', ['controller' => 'Schedule', 'action' => 'override'], ['escapeTitle' => false]) ?></p>
        </div>
    <?php endif; ?>

    <table class="data-table">
        <thead>
            <tr>
                <th>Horario</th>
                <th>Imagen</th>
                <th>Programa</th>
                <th>Producción</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><span class="schedule-hours"><?= $item->horaInicio->i18nFormat('h:mm a', 'en-US') ?> <i class="fa-solid fa-arrow-right"></i> <?= $item->horaFin->i18nFormat('h:mm a', 'en-US') ?></span></td>
                    <td><img class="schedule-thumb" src="<?= $item->image ?>" alt=""></td>
                    <td><span class="schedule-name"><i class="<?= $item->icon ?>"></i>
                            <?= $item->ID !== 999 ? $this->Html->link($item->name, ['controller' => 'Programas', 'action' => 'view', $item->ID]) : $item->name ?></span></td>
                    <td><?= h($item->produccion) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<style>
    .schedule-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: var(--spacing-12);
        flex-wrap: wrap;
        margin-bottom: var(--spacing-12);
    }

    .schedule-tabs {
        display: flex;
        gap: var(--spacing-4);
        border-bottom: 1px solid var(--color-border-subtle);
    }

    .schedule-tab {
        padding: var(--spacing-8) var(--spacing-16);
        font-size: var(--text-body-sm);
        font-weight: var(--font-weight-medium);
        color: var(--color-muted-text);
        text-decoration: none;
        border-bottom: 2px solid transparent;
        margin-bottom: -1px;
        border-radius: var(--radius-buttons) var(--radius-buttons) 0 0;
        transition: color 0.2s, border-color 0.2s;
    }

    .schedule-tab:hover {
        color: var(--color-polar-blue);
        background: rgba(9, 105, 218, 0.05);
    }

    .schedule-tab.active {
        color: var(--color-polar-blue);
        font-weight: var(--font-weight-semibold);
        border-bottom-color: var(--color-polar-blue);
    }

    .schedule-hours {
        white-space: nowrap;
        color: var(--color-muted-text);
        font-variant-numeric: tabular-nums;
    }

    .schedule-name {
        font-weight: var(--font-weight-semibold);
    }

    .schedule-name i {
        margin-right: var(--spacing-8);
        color: var(--color-polar-blue);
    }

    .schedule-thumb {
        width: 64px;
        height: 64px;
        border-radius: var(--radius-default);
        object-fit: cover;
        border: 1px solid var(--color-border-subtle);
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.08);
        vertical-align: middle;
    }

    .data-table tbody tr:hover {
        background: rgba(9, 105, 218, 0.03);
    }
</style>