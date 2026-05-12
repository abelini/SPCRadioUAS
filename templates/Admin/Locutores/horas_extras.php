<div class="page-header">
    <h5><i class="fa-regular fa-clock"></i> Horas extras del periodo:
        <?= $empieza->i18nFormat("d 'de' MMMM") ?>
        <i class="fa-solid fa-arrow-right-long" style="margin: 0 var(--spacing-8);"></i>
        <?= $termina->i18nFormat("d 'de' MMMM") ?>
    </h5>
</div>

<div class="content-card">
    <div class="page-subheader">
        <h5>
            HORAS EXTRAS POR TURNOS DE CABINA DURANTE EL PERÍODO
        </h5>
    </div>

    <div style="padding: var(--spacing-24);">
        <div style="display: flex; align-items: center; gap: var(--spacing-12); margin-bottom: var(--spacing-16);">
            <div
                style="width: 6px; height: 36px; background: var(--color-spring-green); border-radius: var(--radius-sm);">
            </div>
            <p
                style="color: var(--color-ghost-white); font-weight: var(--font-weight-semibold); font-size: var(--text-body); margin: 0;">
                HORAS EXTRAS POR DÍAS INHÁBILES
            </p>
        </div>

        <?php if (count($feriadosDeLaQuincena) > 0): ?>
            <div style="display: flex; flex-wrap: wrap; gap: var(--spacing-8); margin-bottom: var(--spacing-20);">
                <?php foreach ($feriadosDeLaQuincena as $dia): ?>
                    <span
                        style="display: inline-flex; align-items: center; gap: var(--spacing-6); padding:12px 16px; background: rgba(248, 81, 73, 0.15); border-radius: var(--radius-pill); color: #f87171; font-size: var(--text-body-sm);">
                        <i class="fa-regular fa-calendar-xmark"></i>
                        <?= $dia->i18nFormat("eeee d 'de' MMMM") ?>
                    </span>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p style="color: var(--color-ui-gray); margin-bottom: var(--spacing-16);">
                <i class="fa-regular fa-circle-check"></i> No hay días inhábiles en este período
            </p>
        <?php endif; ?>

        <table class="data-table">
            <thead>
                <tr>
                    <th style="color: var(--color-spring-green);">Empleado</th>
                    <th style="color: var(--color-spring-green);">Nombre</th>
                    <th style="color: var(--color-spring-green); text-align: center;">Horas extras</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($horasXCabina) == 0): ?>
                    <tr>
                        <td colspan="3"
                            style="text-align: center; color: var(--color-ui-gray); padding: var(--spacing-32) 0;">
                            <i class="fa-solid fa-circle-check"
                                style="color: var(--color-spring-green); font-size: 24px; display: block; margin-bottom: var(--spacing-8);"></i>
                            No hay días inhábiles en este período
                        </td>
                    </tr>
                <?php endif; ?>
                <?php foreach ($horasXCabina as $locutor): ?>
                    <tr>
                        <td style="font-weight: var(--font-weight-medium);"><?= $locutor['locutor']->empleado ?></td>
                        <td><?= $locutor['locutor']->fullname ?></td>
                        <td style="text-align: center;">
                            <span
                                style="display: inline-flex; align-items: center; gap: var(--spacing-6); padding: var(--spacing-4) var(--spacing-12); background: rgba(26, 127, 55, 0.12); border-radius: var(--radius-pill); color: var(--color-spring-green); font-weight: var(--font-weight-bold);">
                                <i class="fa-solid fa-clock"></i> <?= $locutor['horas'] ?> hrs
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="page-subheader">
        <h5>
            <i class="fa-solid fa-user-tie"></i> HORAS EXTRAS POR EVENTOS CUBIERTOS (Maestros de ceremonia)
        </h5>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th style="color: var(--color-cosmic-violet);">Empleado</th>
                <th style="color: var(--color-cosmic-violet);">Nombre</th>
                <th style="color: var(--color-cosmic-violet); text-align: center;">Horas extras</th>
                <th style="color: var(--color-cosmic-violet);">Foto</th>
                <th style="color: var(--color-cosmic-violet);">Eventos</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($horasXEvento) == 0): ?>
                <tr>
                    <td colspan="5" style="text-align: center; color: var(--color-ui-gray); padding: var(--spacing-32) 0;">
                        <i class="fa-regular fa-face-smile"
                            style="color: var(--color-cosmic-violet); font-size: 24px; display: block; margin-bottom: var(--spacing-8);"></i>
                        No hay eventos registrados
                    </td>
                </tr>
            <?php endif; ?>
            <?php foreach ($horasXEvento as $locutor): ?>
                <tr>
                    <td style="font-weight: var(--font-weight-medium);"><?= $locutor['locutor']->empleado ?></td>
                    <td><?= $locutor['locutor']->fullname ?></td>
                    <td style="text-align: center;">
                        <span
                            style="display: inline-flex; align-items: center; gap: var(--spacing-6); padding: var(--spacing-4) var(--spacing-12); background: rgba(130, 80, 223, 0.12); border-radius: var(--radius-pill); color: var(--color-cosmic-violet); font-weight: var(--font-weight-bold);">
                            <i class="fa-solid fa-clock"></i> <?= $locutor['horas'] ?> hrs
                        </span>
                    </td>
                    <td style="vertical-align: middle;">
                        <?= $this->Html->image($locutor['locutor']->photo, ['style' => 'width: 64px; height: 64px; object-fit: cover; border-radius: var(--radius-md); border: 2px solid var(--color-border-subtle); padding: 2px;']) ?>
                    </td>
                    <td>
                        <div style="display: flex; flex-direction: column; gap: var(--spacing-12);">
                            <?php foreach ($locutor['eventos'] as $evento): ?>
                                <div
                                    style="padding: var(--spacing-8) var(--spacing-12); background: var(--surface-paper); border-radius: var(--radius-md); border: 1px solid var(--color-border-subtle);">
                                    <div
                                        style="display: flex; align-items: center; gap: var(--spacing-8); color: var(--color-cosmic-violet); font-weight: var(--font-weight-medium); font-size: var(--text-body-sm); margin-bottom: var(--spacing-4);">
                                        <i class="fa-solid fa-user-tie"></i>
                                        <?= $evento->shortDesc() ?>
                                    </div>
                                    <div
                                        style="display: flex; align-items: center; gap: var(--spacing-6); color: var(--color-faded-silver); font-size: var(--text-caption);">
                                        <i class="fa-regular fa-calendar-check"></i>
                                        <?= $evento->fecha->i18nFormat(\IntlDateFormatter::LONG) ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>