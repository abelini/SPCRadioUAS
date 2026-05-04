<div class="page-header">
    <h5><i class="fa-solid fa-radio"></i> Programa «<?= $programa ?>»</h5>
</div>

<div class="content-card">
    <table class="view-table">
        <tr>
            <th>Producción</th>
            <td><?= $programa->produccion ?></td>
        </tr>
        <tr>
            <th>Horario</th>
            <td><?= $programa->horaInicio ?> <i class="fa-solid fa-arrow-right-long"></i> <?= $programa->horaFin ?></td>
        </tr>
        <tr>
            <th>Días</th>
            <td>
                <ul>
                    <?php foreach ($programa->dias as $dias): ?>
                        <li><?= $dias->name ?></li>
                    <?php endforeach; ?>
                </ul>
            </td>
        </tr>
    </table>

    <?php if ($programa->reportable): ?>
        <div class="stats-section">
            <div class="page-header">
                <h5><i class="fa-solid fa-chart-simple"></i> Estadísticas del
                    <?= $fechaInicial->i18nFormat("d 'de' MMMM 'de' YYYY") ?> a la fecha (<?= $diff ?>)</h5>
            </div>

            <div class="stats-grid">
                <div class="stats-text">
                    <p>Se han registrado <?= $reportes->count() ?> emisiones de este programa en las bitácoras.</p>

                    <?php if ($reportes->count() > 0): ?>
                        <p>Este programa tiene un cumplimiento del:
                            <strong><?= $this->Number->toPercentage((count($ocurrences['V']) + count($ocurrences['G']) + count($ocurrences['S'])) / $reportes->count(), 1, ['multiply' => true]) ?></strong>.
                        </p>
                        <p>Solo existen <strong><?= count($ocurrences['X']) ?> (<?= $programa->get('XtoWord') ?>)</strong> faltas registradas.</p>
                    <?php endif; ?>
                </div>
                <div>
                    <div id="main-chart" class="chart-container"></div>
                </div>
            </div>

            <?= $this->Html->script('https://www.gstatic.com/charts/loader.js') ?>
            <script type="text/javascript">
                google.charts.load("current", { packages: ["corechart"] });
                google.charts.setOnLoadCallback(drawChart);
                function drawChart() {
                    var data = google.visualization.arrayToDataTable([
                        ["Reporte de programa", "Incidencias en el período"],
                        <?php foreach ($ocurrences as $status => $r): ?>
                            ["<?= $statusLongText[$status] ?>", <?= count($r) ?>],
                        <?php endforeach; ?>
                    ]);

                    var options = {
                        title: "Desglose de reportes del programa",
                        is3D: true,
                        colors: ['#5fed83', 'orange', '#8dd6ff', '#fca5a5'],
                        sliceVisibilityThreshold: 0,
                        backgroundColor: 'transparent',
                        titleTextStyle: { color: '#ffffff' },
                        legendTextStyle: { color: '#f0f6fc' }
                    };

                    let chart = new google.visualization.PieChart(document.getElementById("main-chart"));
                    chart.draw(data, options);
                }
            </script>
        </div>
    <?php endif; ?>

    <div class="actions-bar">
        <?= $this->Html->link('<i class="fa-regular fa-pen-to-square"></i> Modificar', ['action' => 'edit', $programa->ID], ['class' => 'btn btn-outlined', 'escape' => false]) ?>
        <?= $this->Form->deleteLink('<i class="fa-regular fa-trash-can"></i> Eliminar', ['action' => 'delete', $programa->ID], ['confirm' => 'Esto eliminará permanentemente este programa', 'class' => 'btn btn-danger', 'escape' => false]) ?>
    </div>
</div>