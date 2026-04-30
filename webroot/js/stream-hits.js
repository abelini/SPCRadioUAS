const FORMAT_LABEL = { mp3: 'AUDIO', hls: 'VIDEO', m3u8: 'VIDEO' };
const COLORS = { mp3: '#3fb950', hls: '#58a6ff' };
const GRID = '#e8ecf0', TICK = '#656d76';
const $ = id => document.getElementById(id);
const fmt = n => Number(n).toLocaleString('es-MX');

async function loadData() {
    await Promise.all([
        loadKPIs(),
        loadCharts(),
        loadTops(),
        loadGeo(),
        loadRecent()
    ]);
}

async function loadKPIs() {
    try {
        const resp = await fetch(STREAM_HITS_API_URL.summary + (STREAM_HITS_API_PARAMS ? '?' + STREAM_HITS_API_PARAMS : ''));
        const s = await resp.json();
        const grid = document.getElementById('kpi-grid');
        const items = grid.querySelectorAll('.kpi');

        items[0].querySelector('.val').textContent = fmt(s.totalHits || 0);
        items[0].querySelector('.val').classList.remove('loading');
        items[1].querySelector('.val').textContent = fmt(s.hitsToday || 0);
        items[1].querySelector('.val').classList.remove('loading');
        items[2].querySelector('.val').textContent = fmt(s.uniqueIpsToday || 0);
        items[2].querySelector('.val').classList.remove('loading');
        items[3].querySelector('.val').textContent = fmt(s.uniqueReferers || 0);
        items[3].querySelector('.val').classList.remove('loading');

        if (s.topFormat) {
            items[4].querySelector('.val').textContent = FORMAT_LABEL[s.topFormat.format] || s.topFormat.format.toUpperCase();
            items[4].querySelector('.val').classList.remove('loading');
            items[4].querySelector('.sub').textContent = fmt(s.topFormat.cnt) + ' hits';
        }

        if (s.topCountry) {
            items[5].querySelector('.val').textContent = s.topCountry.country || 'N/A';
            items[5].querySelector('.val').classList.remove('loading');
            items[5].querySelector('.sub').textContent = fmt(s.topCountry.cnt) + ' hits';
        }
    } catch (e) { console.error('KPIs error:', e); }
}

async function loadCharts() {
    try {
        const resp = await fetch(STREAM_HITS_API_URL.charts + (STREAM_HITS_API_PARAMS ? '?' + STREAM_HITS_API_PARAMS : ''));
        const data = await resp.json();
        renderDayChart(data.byDay || []);
        renderAVVChart(data.audioVsVideo || []);
        renderHourChart(data.byHour || []);
        renderDonut(data.byFormat || []);
    } catch (e) { console.error('Charts error:', e); }
}

async function loadTops() {
    try {
        const resp = await fetch(STREAM_HITS_API_URL.tops + (STREAM_HITS_API_PARAMS ? '?' + STREAM_HITS_API_PARAMS : ''));
        const data = await resp.json();
        const tops = ['top-domains', 'top-apps', 'top-countries', 'top-agents'];
        tops.forEach(id => document.getElementById(id).classList.remove('loading'));
        document.getElementById('top-domains').innerHTML = renderBarTable(data.topDomains || [], r => r.referer, 'Dominio');
        document.getElementById('top-apps').innerHTML = renderBarTable(data.topApps || [], r => r.referer, 'App');
        document.getElementById('top-countries').innerHTML = renderBarTable(data.topCountries || [], r => (r.countryCode ? countryFlag(r.countryCode) : '') + ' ' + (r.country || '—'), 'País');
        document.getElementById('top-agents').innerHTML = renderBarTable(data.topUserAgents || [], r => r.identified || r.userAgent || '—', 'Dispositivo');
    } catch (e) { console.error('Tops error:', e); }
}

async function loadGeo() {
        try {
            const resp = await fetch(STREAM_HITS_API_URL.geo + (STREAM_HITS_API_PARAMS ? '?' + STREAM_HITS_API_PARAMS : ''));
            const geoPoints = await resp.json();
            renderMap(geoPoints || []);
        } catch (e) { console.error('Geo error:', e); }
    }

async function loadRecent() {
    try {
        const resp = await fetch(STREAM_HITS_API_URL.recent + (STREAM_HITS_API_PARAMS ? '?' + STREAM_HITS_API_PARAMS : ''));
        const recent = await resp.json();
        document.getElementById('recent-table').classList.remove('loading');
        document.getElementById('recent-table').innerHTML = renderRecentTable(recent || []);
    } catch (e) { console.error('Recent error:', e); }
}

function countryFlag(code) {
    if (!code || code.length !== 2) return '';
    const cp = [...code.toUpperCase()].map(c => 0x1F1E6 + c.charCodeAt(0) - 65);
    return cp.map(c => String.fromCodePoint(c)).join('');
}

function renderBarTable(rows, renderCell, label) {
    if (!rows.length) return '<p class="em">Sin datos.</p>';
    const max = +rows[0].total;
    let h = '<div class="tbl-wrap"><table><thead><tr><th class="w3-deep-blue" style="padding-left:8px">' + label + '</th><th class="w3-deep-blue" style="padding-left:8px">Hits</th></tr></thead><tbody>';
    rows.forEach(r => {
        const pct = max > 0 ? Math.round((+r.total / max) * 110) : 0;
        h += '<tr><td>' + (renderCell(r) || '—') + '</td><td class="mono">' + fmt(+r.total) + '<div class="bar-wrap" style="margin-top:4px"><div class="bar" style="width:' + pct + 'px"></div></div></td></tr>';
    });
    return h + '</tbody></table></div>';
}

function renderRecentTable(rows) {
    if (!rows.length) return '<p class="em">Sin datos.</p>';
    let h = '<div class="tbl-wrap"><table><thead><tr><th class="w3-deep-blue" style="padding-left:8px">Formato</th><th class="w3-deep-blue" style="padding-left:8px">Origen</th><th class="w3-deep-blue" style="padding-left:8px">Tipo</th><th class="w3-deep-blue" style="padding-left:8px">IP</th><th class="w3-deep-blue" style="padding-left:8px">Ciudad</th><th class="w3-deep-blue" style="padding-left:8px">Fecha</th></tr></thead><tbody>';
    rows.forEach(r => {
        h += '<tr>';
        h += '<td><span class="badge ' + r.format + '">' + (FORMAT_LABEL[r.format] || r.format) + '</span></td>';
        h += '<td>' + (r.referer || '—').substring(0, 30) + '</td>';
        h += '<td><span class="badge type-' + (r.refererType || 'app') + '">' + (r.refererType || 'app') + '</span></td>';
        h += '<td class="mono">' + (r.ip || '—') + '</td>';
        h += '<td>' + (r.countryCode ? countryFlag(r.countryCode) + ' ' : '') + (r.city || '—') + '</td>';
        h += '<td class="mono">' + (r.created ? r.created.substring(0, 16).replace('T', ' ') : '—') + '</td>';
        h += '</tr>';
    });
    return h + '</tbody></table></div>';
}

document.addEventListener('DOMContentLoaded', loadData);

const charts = {};

function mkChart(id, config) {
    if (charts[id]) charts[id].destroy();
    charts[id] = new Chart($(id), config);
}

function chartDefaults(extra = {}) {
    return {
        responsive: true, maintainAspectRatio: true,
        plugins: { legend: { labels: { color: '#1f2328', font: { size: 11 } } } },
        scales: {
            x: { ticks: { color: TICK, maxTicksLimit: 10 }, grid: { color: GRID } },
            y: { ticks: { color: TICK }, grid: { color: GRID }, beginAtZero: true },
        },
        ...extra,
    };
}

function renderDayChart(rows) {
    const days = [...new Set(rows.map(r => r.day))].sort();
    const formats = [...new Set(rows.map(r => r.format))];
    const datasets = formats.map(f => ({
        label: FORMAT_LABEL[f] ?? f,
        data: days.map(d => (rows.find(r => r.day === d && r.format === f) ?? { total: 0 }).total),
        borderColor: COLORS[f] ?? '#7d8590',
        backgroundColor: (COLORS[f] ?? '#7d8590') + '20',
        tension: .35, fill: true, pointRadius: 2,
    }));
    mkChart('chartDay', { type: 'line', data: { labels: days, datasets }, options: chartDefaults() });
}

function renderAVVChart(rows) {
    const days = rows.map(r => r.day);
    const audio = rows.map(r => r.audio ?? 0);
    const video = rows.map(r => r.video ?? 0);
    mkChart('chartAVV', {
        type: 'bar',
        data: {
            labels: days,
            datasets: [
                { label: 'Audio', data: audio, backgroundColor: '#3fb95088', borderColor: '#3fb950', borderWidth: 1, borderRadius: 3 },
                { label: 'Video', data: video, backgroundColor: '#58a6ff88', borderColor: '#58a6ff', borderWidth: 1, borderRadius: 3 },
            ],
        },
        options: chartDefaults(),
    });
}

function renderHourChart(rows) {
    const labels = Array.from({ length: 24 }, (_, i) => String(i).padStart(2, '0') + 'h');
    const data = Array(24).fill(0);
    rows.forEach(r => { data[parseInt(r.hour, 10)] = r.total; });
    mkChart('chartHour', {
        type: 'bar',
        data: { labels, datasets: [{ label: 'Hits', data, backgroundColor: '#58a6ff30', borderColor: '#58a6ff', borderWidth: 1, borderRadius: 3 }] },
        options: chartDefaults({ plugins: { legend: { display: false } } }),
    });
}

function renderDonut(rows) {
    const labels = rows.map(r => FORMAT_LABEL[r.format] ?? r.format);
    const data = rows.map(r => r.total);
    const colors = rows.map(r => COLORS[r.format] ?? '#7d8590');
    mkChart('chartDonut', {
        type: 'doughnut',
        data: { labels, datasets: [{ data, backgroundColor: colors.map(c => c + 'cc'), borderColor: colors, borderWidth: 2 }] },
        options: {
            responsive: true, maintainAspectRatio: true, cutout: '65%',
            plugins: { legend: { position: 'bottom', labels: { color: '#1f2328', font: { size: 12 }, padding: 16 } } },
        },
    });
}

let leafletMap = null;
let markersLayer = null;

function renderMap(points) {
    if (!leafletMap) {
        leafletMap = L.map('map', { zoomControl: true, attributionControl: true })
            .setView([20, 0], 2);

        L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
            attribution: '© OpenStreetMap © CARTO',
            subdomains: 'abcd', maxZoom: 19,
        }).addTo(leafletMap);

        markersLayer = L.layerGroup().addTo(leafletMap);
    }

    markersLayer.clearLayers();

    if (!points.length) return;

    const hasTotal = points[0].total !== undefined;
    const maxTotal = hasTotal ? Math.max(...points.map(p => p.total)) : points.length;

    points.forEach(p => {
        if (!p.lat || !p.lon) return;

        const lat = parseFloat(p.lat);
        const lon = parseFloat(p.lon);
        
        const total = p.total || 1;
        const radius = hasTotal ? Math.max(5, Math.min(40, Math.sqrt(total) * 2)) : 3;
        
        const circle = L.circleMarker([lat, lon], {
            radius,
            fillColor: '#0969da',
            color: '#0550ae',
            weight: 1,
            opacity: .9,
            fillOpacity: .6,
        });

        const cityCountry = (p.city ? p.city + ', ' : '') + (p.country || '—');
        const hitsText = hasTotal ? fmt(total) + ' hits' : '1 hit';

        circle.bindPopup(`
        <div style="font-family:monospace;font-size:13px;min-width:140px;color:#1f2328">
            <strong>${cityCountry}</strong><br>
            <span style="color:#58a6ff">${hitsText}</span>
        </div>
    `);

        markersLayer.addLayer(circle);
    });
}