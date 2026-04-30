<?php

$this->assign('title', 'Estadísticas de Streaming');

$this->Html->css('stream-hits', ['block' => 'css']);
$this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js', ['block' => 'scriptBottom']);
$this->Html->css('https://unpkg.com/leaflet@1.9.4/dist/leaflet.css', ['block' => 'css']);
$this->Html->script('https://unpkg.com/leaflet@1.9.4/dist/leaflet.js', ['block' => 'scriptBottom']);
?>

<div class="content">

    <div class="w3-deep-blue w3-padding">
        <h5><i class="fa-regular fa-clock"></i> Estadísticas de Streaming</h5>
    </div>
    <div class="w3-low-blue w3-padding w3-center">
        <h6 style="text-transform:uppercase">
            <?= $from->i18nFormat("d 'de' MMMM") ?> <i class="fa-solid fa-arrow-right-long"></i>
            <?= $to->i18nFormat("d 'de' MMMM") ?>
        </h6>
    </div>

    <!-- Filtros de fecha -->
    <?= $this->Form->create(null, ['method' => 'get', 'class' => 'filters']) ?>

    <?= $this->Form->control('from', ['type' => 'date', 'label' => false, 'value' => $from->format('Y-m-d'), 'class' => 'w3-input', 'div' => false]) ?>

    <i class="fa-solid fa-arrow-right-long"></i>

    <?= $this->Form->control('to', ['type' => 'date', 'label' => false, 'value' => $to->format('Y-m-d'), 'class' => 'w3-input', 'div' => false]) ?>

    <div class="btn-group">
        <?= $this->Html->link('7 días', ['action' => 'index', '?' => ['from' => (new DateTime('-7 days'))->format('Y-m-d'), 'to' => (new DateTime())->format('Y-m-d')]], ['class' => 'w3-button w3-light-gray ' . ($from->format('Y-m-d') === (new DateTime('-7 days'))->format('Y-m-d') && $to->format('Y-m-d') === (new DateTime())->format('Y-m-d') ? 'active' : '')]) ?>
        <?= $this->Html->link('Hoy', ['action' => 'index', '?' => ['from' => (new DateTime())->format('Y-m-d'), 'to' => (new DateTime())->format('Y-m-d')]], ['class' => 'w3-button w3-light-gray ' . ($from->format('Y-m-d') === (new DateTime())->format('Y-m-d') && $to->format('Y-m-d') === (new DateTime())->format('Y-m-d') ? 'active' : '')]) ?>
        <?= $this->Html->link('30 días', ['action' => 'index', '?' => ['from' => (new DateTime('-30 days'))->format('Y-m-d'), 'to' => (new DateTime())->format('Y-m-d')]], ['class' => 'w3-button w3-light-gray ' . ($from->format('Y-m-d') === (new DateTime('-30 days'))->format('Y-m-d') && $to->format('Y-m-d') === (new DateTime())->format('Y-m-d') ? 'active' : '')]) ?>
        <?= $this->Html->link('90 días', ['action' => 'index', '?' => ['from' => (new DateTime('-90 days'))->format('Y-m-d'), 'to' => (new DateTime())->format('Y-m-d')]], ['class' => 'w3-button w3-light-gray ' . ($from->format('Y-m-d') === (new DateTime('-90 days'))->format('Y-m-d') && $to->format('Y-m-d') === (new DateTime())->format('Y-m-d') ? 'active' : '')]) ?>
    </div>

    <?= $this->Form->button('Aplicar →', ['class' => 'w3-button w3-red']) ?>
    <?= $this->Form->end() ?>

    <!-- KPIs -->
    <section id="kpi-section">
        <h2>Resumen General</h2>
        <div class="kpi-grid" id="kpi-grid">
            <div class="kpi c1">
                <div class="lbl">Total Hits</div>
                <div class="val loading">—</div>
                <div class="sub">
                    <?= $from->format('Y-m-d') === $to->format('Y-m-d') ? 'Hoy' : $from->format('Y-m-d') . ' al ' . $to->format('Y-m-d') ?>
                </div>
            </div>
            <div class="kpi c2">
                <div class="lbl">Hits Hoy</div>
                <div class="val loading">—</div>
                <div class="sub"><?= (new DateTime())->format('Y-m-d') ?></div>
            </div>
            <div class="kpi c3">
                <div class="lbl">IPs Únicas Hoy</div>
                <div class="val loading">—</div>
                <div class="sub">visitantes únicos</div>
            </div>
            <div class="kpi c4">
                <div class="lbl">Orígenes Únicos</div>
                <div class="val loading">—</div>
                <div class="sub">distintas fuentes</div>
            </div>
            <div class="kpi c5">
                <div class="lbl">Formato Top</div>
                <div class="val loading">—</div>
                <div class="sub">en período</div>
            </div>
            <div class="kpi c6">
                <div class="lbl">País Top</div>
                <div class="val loading">—</div>
                <div class="sub">oyentes</div>
            </div>
        </div>
    </section>

    <!-- Gráficas principales -->
    <section>
        <h2>Tendencias</h2>
        <div class="grid2">
            <div class="card">
                <h3>Hits por día</h3>
                <canvas id="chartDay"></canvas>
            </div>
            <div class="card">
                <h3>Audio vs Video</h3>
                <canvas id="chartAVV"></canvas>
            </div>
            <div class="card">
                <h3>Distribución por hora</h3>
                <canvas id="chartHour"></canvas>
            </div>
            <div class="card">
                <h3>Proporción Audio / Video</h3>
                <canvas id="chartDonut"></canvas>
            </div>
        </div>
    </section>

    <!-- Top Consumidores -->
    <section>
        <h2>Top Consumidores</h2>
        <div class="grid3">
            <div class="card">
                <h3>Top Dominios</h3>
                <div id="top-domains" class="loading">
                    <div class="loading-skeleton" style="height:200px"></div>
                </div>
            </div>
            <div class="card">
                <h3>Top Apps</h3>
                <div id="top-apps" class="loading">
                    <div class="loading-skeleton" style="height:200px"></div>
                </div>
            </div>
            <div class="card">
                <h3>Top Países</h3>
                <div id="top-countries" class="loading">
                    <div class="loading-skeleton" style="height:200px"></div>
                </div>
            </div>
            <div class="card">
                <h3>Top User Agents</h3>
                <div id="top-agents" class="loading">
                    <div class="loading-skeleton" style="height:200px"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mapa y Recientes -->
    <section>
        <h2>Mapa y Recientes</h2>
        <div class="grid2" style="grid-template-columns: 1fr 1fr;">
            <div class="card">
                <h3>Mapa de Oyentes</h3>
                <div id="map"></div>
            </div>
            <div class="card">
                <h3>Hits Recientes</h3>
                <div id="recent-table" class="loading">
                    <div class="loading-skeleton" style="height:300px"></div>
                </div>
            </div>
        </div>
    </section>

</div>

<?= $this->fetch('scriptBottom') ?>
<script>
    var STREAM_HITS_API_PARAMS = '<?= http_build_query($this->request->getQuery()) ?>';
    var STREAM_HITS_API_URL = {
        summary: '<?= $this->Url->build(['action' => 'apiSummary']) ?>',
        charts: '<?= $this->Url->build(['action' => 'apiCharts']) ?>',
        tops: '<?= $this->Url->build(['action' => 'apiTops']) ?>',
        geo: '<?= $this->Url->build(['action' => 'apiGeo']) ?>',
        recent: '<?= $this->Url->build(['action' => 'apiRecent']) ?>',
    };
</script>
<script src="<?= $this->Url->build('/js/stream-hits.js') ?>"></script>