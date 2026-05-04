<div class="page-header">
    <h5><i class="fa-regular fa-clock"></i> Horas extras del personal para la quincena</h5>
</div>

<div class="content-card">
    <div style="background-color: var(--surface-code-canvas); padding: var(--spacing-12); border-radius: var(--radius-cards) var(--radius-cards) 0 0; text-align: center;">
        <h6 style="color: var(--color-ghost-white); text-transform: uppercase;"><?= $empieza->i18nFormat("d 'de' MMMM")?> <i class="fa-solid fa-arrow-right-long"></i> <?= $termina->i18nFormat("d 'de' MMMM")?></h6>
    </div>

    <div style="padding: var(--spacing-16);">
        <p style="color: var(--color-ghost-white); font-weight: var(--font-weight-semibold); margin-bottom: var(--spacing-12);">HORAS EXTRAS POR DÍAS INHÁBILES:</p>
        <ul style="list-style: none; padding: 0; margin-bottom: var(--spacing-16);">
            <?php foreach($feriadosDeLaQuincena as $dia) : ?>
                <li style="color: var(--color-faded-silver); padding: var(--spacing-4) 0;"><i class="fa-regular fa-calendar-xmark"></i> <?= $dia->i18nFormat("eeee d 'de' MMMM") ?></li>
            <?php endforeach; ?>
        </ul>

        <table class="data-table">
            <thead>
                <tr>
                    <th>Empleado</th>
                    <th>Nombre</th>
                    <th>Horas extras</th>
                </tr>
            </thead>
            <tbody>
                <?php if(count($horasXCabina) ==0) : ?>
                    <tr>
                        <td colspan="3" style="text-align: center; color: var(--color-ui-gray);">No hay días inhábiles en este período</td>
                    </tr>
                <?php endif; ?>
                <?php foreach($horasXCabina as $locutor) : ?>
                    <tr>
                        <td><?= $locutor['locutor']->empleado ?></td>
                        <td><?= $locutor['locutor']->fullname ?></td>
                        <td><?= $locutor['horas'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="content-card" style="margin-top: var(--spacing-24);">
    <div class="page-header">
        <h6><i class="fa-solid fa-user-tie"></i> HORAS EXTRAS POR EVENTOS CUBIERTOS (Maestros de ceremonia)</h6>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th>Empleado</th>
                <th>Nombre</th>
                <th>Horas extras</th>
                <th>Foto</th>
                <th>Eventos</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($horasXEvento as $locutor) : ?>
                <tr>
                    <td><?= $locutor['locutor']->empleado ?></td>
                    <td><?= $locutor['locutor']->fullname ?></td>
                    <td><?= $locutor['horas'] ?></td>
                    <td style="vertical-align: middle;">
                        <?= $this->Html->image($locutor['locutor']->photo, ['style' => 'width: 80px; padding: 4px; border-radius: var(--radius-md);'])?>
                    </td>
                    <td>
                        <ul style="list-style: none; padding: 0;">
                            <?php foreach($locutor['eventos'] as $evento) : ?>
                                <li style="color: var(--color-faded-silver); padding: var(--spacing-4) 0;"><i class="fa-solid fa-user-tie"></i> <?= $evento->shortDesc() ?></li>
                                <li style="color: var(--color-faded-silver); padding: var(--spacing-4) 0;"><i class="fa-regular fa-calendar-check"></i> <?= $evento->fecha->i18nFormat(\IntlDateFormatter::LONG) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>