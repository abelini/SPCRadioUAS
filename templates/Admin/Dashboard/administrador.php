<div class="page-header">
    <h3>Bienvenido, <?= $user->name ?></h3>
</div>

<div class="content-card" style="padding: var(--spacing-24);">
    <div class="row g-4">
        <div class="col-md-4">
            <h5><i class="fa-solid fa-bell"></i> Estado del sistema</h5>

            <div class="alert alert-success"
                style="padding: var(--spacing-16); margin-top: var(--spacing-16); background: rgba(34, 197, 94, 0.15); border-left: 4px solid #22c55e;">
                <h5 style="color: #22c55e;">Sin novedad</h5>
                <p>Todo marcha a la perfección.</p>
            </div>
        </div>

        <div class="col-md-8">
            <h5><i class="fa-solid fa-chart-simple"></i> Distribución de Solicitudes</h5>

            <p style="padding: var(--spacing-16) 0;">Hay <strong><?= $solicitudes['Total'] ?></strong> solicitudes
                registradas en el sistema.</p>

            <div class="row g-3" style="padding: var(--spacing-16) 0;">
                <div class="col-md-5">
                    <div
                        style="border-left: 4px solid #9333ea; padding-left: var(--spacing-16); margin-bottom: var(--spacing-20);">
                        <div style="color: var(--color-muted-gray);">Grabaciones de spot</div>
                        <strong
                            style="font-size: 1.5rem;"><?= $this->Number->format($solicitudes['TotalGDS']) ?></strong>
                    </div>

                    <div
                        style="border-left: 4px solid #22c55e; padding-left: var(--spacing-16); margin-bottom: var(--spacing-20);">
                        <div style="color: var(--color-muted-gray);">Maestros de ceremonia</div>
                        <strong
                            style="font-size: 1.5rem;"><?= $this->Number->format($solicitudes['TotalMDC']) ?></strong>
                    </div>

                    <div style="border-left: 4px solid #f59e0b; padding-left: var(--spacing-16);">
                        <div style="color: var(--color-muted-gray);">Controles remotos</div>
                        <strong
                            style="font-size: 1.5rem;"><?= $this->Number->format($solicitudes['TotalCR']) ?></strong>
                    </div>
                </div>

                <div class="col-md-7" style="padding: var(--spacing-16);">
                    <div
                        style="background-color: var(--color-border-light); margin-bottom: var(--spacing-12); border-radius: var(--radius-md); height: 32px; overflow: hidden;">
                        <div
                            style="background-color: #9333ea; padding: var(--spacing-8); width: <?= ($solicitudes['TotalGDS'] / $solicitudes['Total'] * 100) ?>%; height: 100%; border-radius: var(--radius-md); color: #fff; font-size: 0.875rem;">
                            <?= $this->Number->format($solicitudes['TotalGDS']) ?>
                        </div>
                    </div>

                    <div
                        style="background-color: var(--color-border-light); margin-bottom: var(--spacing-12); border-radius: var(--radius-md); height: 32px; overflow: hidden;">
                        <div
                            style="background-color: #22c55e; padding: var(--spacing-8); width: <?= ($solicitudes['TotalMDC'] / $solicitudes['Total'] * 100) ?>%; height: 100%; border-radius: var(--radius-md); color: #fff; font-size: 0.875rem;">
                            <?= $this->Number->format($solicitudes['TotalMDC']) ?>
                        </div>
                    </div>

                    <div
                        style="background-color: var(--color-border-light); margin-bottom: var(--spacing-12); border-radius: var(--radius-md); height: 32px; overflow: hidden;">
                        <div
                            style="background-color: #f59e0b; padding: var(--spacing-8); width: <?= ($solicitudes['TotalCR'] / $solicitudes['Total'] * 100) ?>%; height: 100%; border-radius: var(--radius-md); color: #fff; font-size: 0.875rem;">
                            <?= $this->Number->format($solicitudes['TotalCR']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4" style="margin-top: var(--spacing-24);">
    <div class="col-md-3" id="card-streaming" style="min-height: 150px;">
        <div class="content-card" style="height: 100%;">
            <h5><i class="fa-solid fa-radio"></i> Streaming (7 días)</h5>
            <div class="stat-loading"
                style="padding: var(--spacing-24); text-align: center; color: var(--color-muted-gray);">
                <i class="fa-solid fa-circle-notch fa-spin"></i> Cargando...
            </div>
        </div>
    </div>

    <div class="col-md-3" id="card-solicitudes" style="min-height: 150px;">
        <div class="content-card" style="height: 100%;">
            <h5><i class="fa-solid fa-folder-open"></i> Solicitudes Pendientes</h5>
            <div class="stat-loading"
                style="padding: var(--spacing-24); text-align: center; color: var(--color-muted-gray);">
                <i class="fa-solid fa-circle-notch fa-spin"></i> Cargando...
            </div>
        </div>
    </div>

    <div class="col-md-3" id="card-incidencias" style="min-height: 150px;">
        <div class="content-card" style="height: 100%;">
            <h5><i class="fa-solid fa-file-signature"></i> Incidencias Abiertas</h5>
            <div class="stat-loading"
                style="padding: var(--spacing-24); text-align: center; color: var(--color-muted-gray);">
                <i class="fa-solid fa-circle-notch fa-spin"></i> Cargando...
            </div>
        </div>
    </div>

    <div class="col-md-3" id="card-bitacora" style="min-height: 150px;">
        <div class="content-card" style="height: 100%;">
            <h5><i class="fa-solid fa-file-contract"></i> Bitácora Hoy</h5>
            <div class="stat-loading"
                style="padding: var(--spacing-24); text-align: center; color: var(--color-muted-gray);">
                <i class="fa-solid fa-circle-notch fa-spin"></i> Cargando...
            </div>
        </div>
    </div>
</div>

<div class="row g-4" style="margin-top: var(--spacing-24);">
    <div class="col-md-12" id="card-roles" style="min-height: 120px;">
        <div class="content-card">
            <h5><i class="fa-solid fa-microphone-lines"></i> Roles de Cabina para la siguiente semana</h5>
            <div class="stat-loading"
                style="padding: var(--spacing-24); text-align: center; color: var(--color-muted-gray);">
                <i class="fa-solid fa-circle-notch fa-spin"></i> Cargando...
            </div>
        </div>
    </div>
</div>

<script>
    async function loadDashboardCards() {
        const theme = '<?= $theme ?>';
        const colors = theme === 'midnight'
            ? { primary: '#8dd6ff', success: '#5fed83', warning: '#f59e0b', danger: '#fca5a5', bg: '#21262d', text: '#f0f6fc' }
            : { primary: '#0969da', success: '#22c55e', warning: '#d97706', danger: '#cf222e', bg: '#f6f8fa', text: '#1f2328' };

        async function loadCard(url, cardId, renderFn) {
            try {
                const response = await fetch(url);
                const data = await response.json();
                const card = document.getElementById(cardId);
                const content = card.querySelector('.content-card');
                content.innerHTML = renderFn(data, colors);
            } catch (e) {
                console.error('Error loading', cardId, e);
            }
        }

        loadCard('<?= $this->Url->build(['controller' => 'Dashboard', 'action' => 'streamingStats']) ?>', 'card-streaming', (data, c) => `
        <h5><i class="fa-solid fa-radio"></i> Streaming (7 días)</h5>
        <div style="padding: var(--spacing-16) 0;">
            <div style="font-size: 2.5rem; font-weight: bold; color: ${c.primary};">${data.totalListeners.toLocaleString()}</div>
            <div style="color: ${c.text};">oyentes totales</div>
            <div style="margin-top: var(--spacing-16); font-size: 0.875rem; color: ${c.success};">
                <i class="fa-solid fa-arrow-up"></i> ${data.maxDay}
            </div>
            <div style="font-size: 0.75rem; color: ${c.text}; opacity: 0.7;">día con más conexiones</div>
        </div>
    `);

        loadCard('<?= $this->Url->build(['controller' => 'Dashboard', 'action' => 'solicitudesPendientes']) ?>', 'card-solicitudes', (data, c) => `
        <h5><i class="fa-solid fa-folder-open"></i> Solicitudes Pendientes</h5>
        <div style="padding: var(--spacing-16) 0;">
            <div style="font-size: 2.5rem; font-weight: bold; color: ${data.pendientes > 0 ? c.warning : c.success};">${data.pendientes}</div>
            <div style="color: ${c.text};">sin atender</div>
            ${data.pendientes > 0 ? `<a href="<?= $this->Url->build(['controller' => 'Solicitudes', 'status' => 'pendiente']) ?>" style="color: ${c.primary}; margin-top: var(--spacing-16); display: block;">
                <i class="fa-solid fa-arrow-right"></i> Ver solicitudes
            </a>` : ''}
        </div>
    `);

        loadCard('<?= $this->Url->build(['controller' => 'Dashboard', 'action' => 'incidenciasAbiertas']) ?>', 'card-incidencias', (data, c) => `
        <h5><i class="fa-solid fa-file-signature"></i> Incidencias Abiertas</h5>
        <div style="padding: var(--spacing-16) 0;">
            <div style="font-size: 2.5rem; font-weight: bold; color: ${data.abiertas > 0 ? c.danger : c.success};">${data.abiertas}</div>
            <div style="color: ${c.text};">incidencias activas</div>
            ${data.abiertas > 0 ? `<a href="<?= $this->Url->build(['controller' => 'Incidencias', 'status' => 'abierta']) ?>" style="color: ${c.primary}; margin-top: var(--spacing-16); display: block;">
                <i class="fa-solid fa-arrow-right"></i> Ver incidencias
            </a>` : ''}
        </div>
    `);

        loadCard('<?= $this->Url->build(['controller' => 'Dashboard', 'action' => 'bitacoraHoy']) ?>', 'card-bitacora', (data, c) => `
        <h5><i class="fa-solid fa-file-contract"></i> Bitácora Hoy</h5>
        <div style="padding: var(--spacing-16) 0;">
            <div style="font-size: 2.5rem; font-weight: bold; color: ${c.primary};">${data.registros}</div>
            <div style="color: ${c.text};">registros hoy</div>
            ${data.registros > 0 ? `<a href="<?= $this->Url->build(['controller' => 'BitacoraCabina']) ?>?date=${data.fecha}" style="color: ${c.primary}; margin-top: var(--spacing-16); display: block;">
                <i class="fa-solid fa-arrow-right"></i> Ver bitácora
            </a>` : ''}
        </div>
    `);

        loadCard('<?= $this->Url->build(['controller' => 'Dashboard', 'action' => 'rolesProximaSemana']) ?>', 'card-roles', (data, c) => `
        <h5><i class="fa-solid fa-microphone-lines"></i> Roles de Cabina para la próxima semana</h5>
        <div style="padding: var(--spacing-16) 0;">
            ${data.existe
                ? `<div style="color: ${c.success};"><i class="fa-solid fa-check-circle"></i> El rol para la semana del ${data.semanaInicio} al ${data.semanaFin} ya está registrado</div>`
                : `<div style="color: ${c.warning};"><i class="fa-solid fa-exclamation-circle"></i> No se ha registrado rol de cabina para la próxima semana</div>
                   <a href="<?= $this->Url->build(['controller' => 'Roles', 'action' => 'add']) ?>" style="color: ${c.primary}; margin-top: var(--spacing-16); display: inline-block;">
                       <i class="fa-solid fa-plus"></i> Crear role de cabina
                   </a>`
            }
        </div>
    `);
    }

    document.addEventListener('DOMContentLoaded', loadDashboardCards);
</script>

<div style="text-align: right; padding: var(--spacing-24); color: var(--color-muted-gray);">
    <?= $datetime->i18nFormat(IntlDateFormatter::FULL) ?>
</div>