<div class="page-header">
    <h5><i class="fa-solid fa-table-list"></i> Rol de cabina #<?= $rol->ID ?></h5>
</div>

<div class="content-card">
    <table class="view-table">
        <tr>
            <th>Tipo de horario</th>
            <td>
                <?= $this->Html->link($rol->turno->name, ['controller' => 'Turnos', 'action' => 'view', $rol->turno->ID]) ?>
            </td>
        </tr>
        <tr>
            <th>Empieza el día</th>
            <td>
                <?= $rol->fechaInicio->i18nFormat("EEEE d 'de' MMMM 'de' YYYY") ?>
            </td>
        </tr>
        <tr>
            <th>Termina el día</th>
            <td>
                <?= $rol->fechaFin->i18nFormat("EEEE d 'de' MMMM 'de' YYYY") ?>
            </td>
        </tr>
    </table>

    <div class="stats-section">
        <div class="page-header">
            <h5><i class="fa-solid fa-calendar-week"></i> Asignaciones de la semana</h5>
        </div>

        <table class="data-table by-day">
            <?php foreach ($asignaciones as $dateKey => $asignaciones): ?>
                <tr>
                    <td class="day">
                        <?php
                        $isMobile = false;
                        try {
                            $isMobile = $this->request->is('mobile');
                        } catch (\Detection\Exception\MobileDetectException $e) {
                            $isMobile = false;
                        }
                        echo (new \Cake\I18n\Date($dateKey))->i18nFormat($isMobile ? 'EEEEE' : 'EEEE');
                        ?>
                    </td>
                    <td class="grid">
                        <table class="data-table by-time">
                            <thead>
                                <tr>
                                    <th class="hide-on-mobile">Asignación</th>
                                    <th>Operador</th>
                                    <th>Turno</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($asignaciones as $asignacion): ?>
                                    <tr>
                                        <td class="hide-on-mobile"><?= $asignacion->ID ?></td>
                                        <td><i class="fa-solid fa-user hide-on-mobile"></i> <?= $asignacion->locutor->name ?></td>
                                        <td><?= $asignacion->horario->horaInicio ?> <i class="fa-solid fa-arrow-right-long"></i> <?= $asignacion->horario->horaFin ?></td>
                                        <td>
                                            <?= $this->Html->link('<i class="fa-solid fa-rotate"></i>', ['controller' => 'asignaciones', 'action' => 'edit', $asignacion->ID], ['escapeTitle' => false]) ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <div class="actions-bar">
        <?= $this->Html->link('<i class="fa-regular fa-pen-to-square"></i> Modificar', ['action' => 'edit', $rol->ID], ['class' => 'btn btn-outlined', 'escapeTitle' => false]) ?>
        <?= $this->Form->deleteLink('<i class="fa-regular fa-trash-can"></i> Eliminar', ['action' => 'delete', $rol->ID], ['confirm' => '¿Estás seguro de eliminar este rol?', 'class' => 'btn btn-danger', 'escapeTitle' => false]) ?>
    </div>
</div>

<style>
    .by-time {
        margin: 0;
    }

    .grid {
        padding: 0 !important;
    }

    .day {
        letter-spacing: 2px;
        font-size: 20px;
        text-transform: uppercase;
        width: 180px;
        color: var(--color-ghost-white);
    }

    td i {
        padding: 0 12px;
    }

    @media only screen and (max-width: 600px) {
        .day {
            width: 40px !important;
            font-size: 14px;
        }

        td i {
            padding: 0;
        }
    }
</style>