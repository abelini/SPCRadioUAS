<div class="page-header">
    <h3><i class="fa-solid fa-chart-simple"></i> Estadísticas del sistema</h3>
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

            <p style="padding: var(--spacing-16) 0;">Hay <strong>
                    <?= $solicitudes['Total'] ?>
                </strong> solicitudes
                registradas en el sistema.</p>

            <div style="padding: var(--spacing-16) 0;">
                <div style="margin-bottom: var(--spacing-12);">
                    <div style="display: table; width: 100%;">
                        <div style="display: table-cell; width: 41.66%; vertical-align: middle;">
                            <div style="border-left: 4px solid #9333ea; padding-left: var(--spacing-12);">
                                <div style="color: var(--color-muted-gray); font-size: 0.875rem;">Grabaciones de spot
                                </div>
                                <strong style="font-size: 1.25rem;">
                                    <?= $this->Number->format($solicitudes['TotalGDS']) ?>
                                </strong>
                            </div>
                        </div>
                        <div style="display: table-cell; width: 58.33%; vertical-align: middle;">
                            <div
                                style="background-color: var(--color-border-light); height: 50px; border-radius: var(--radius-md); overflow: hidden;">
                                <div
                                    style="background-color: #9333ea; width: <?= ($solicitudes['TotalGDS'] / $solicitudes['Total'] * 100) ?>%; height: 100%; border-radius: var(--radius-md); color: #fff; font-size: 1.25rem; padding: var(--spacing-8) var(--spacing-12);">
                                    <?= $this->Number->format($solicitudes['TotalGDS']) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div style="margin-bottom: var(--spacing-12);">
                    <div style="display: table; width: 100%;">
                        <div style="display: table-cell; width: 41.66%; vertical-align: middle;">
                            <div style="border-left: 4px solid #22c55e; padding-left: var(--spacing-12);">
                                <div style="color: var(--color-muted-gray); font-size: 0.875rem;">Maestros de ceremonia
                                </div>
                                <strong style="font-size: 1.25rem;">
                                    <?= $this->Number->format($solicitudes['TotalMDC']) ?>
                                </strong>
                            </div>
                        </div>
                        <div style="display: table-cell; width: 58.33%; vertical-align: middle;">
                            <div
                                style="background-color: var(--color-border-light); height: 50px; border-radius: var(--radius-md); overflow: hidden;">
                                <div
                                    style="background-color: #22c55e; width: <?= ($solicitudes['TotalMDC'] / $solicitudes['Total'] * 100) ?>%; height: 100%; border-radius: var(--radius-md); color: #fff; font-size: 1.25rem; padding: var(--spacing-8) var(--spacing-12);">
                                    <?= $this->Number->format($solicitudes['TotalMDC']) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <div style="display: table; width: 100%;">
                        <div style="display: table-cell; width: 41.66%; vertical-align: middle;">
                            <div style="border-left: 4px solid #f59e0b; padding-left: var(--spacing-12);">
                                <div style="color: var(--color-muted-gray); font-size: 0.875rem;">Controles remotos
                                </div>
                                <strong style="font-size: 1.25rem;">
                                    <?= $this->Number->format($solicitudes['TotalCR']) ?>
                                </strong>
                            </div>
                        </div>
                        <div style="display: table-cell; width: 58.33%; vertical-align: middle;">
                            <div
                                style="background-color: var(--color-border-light); height: 50px; border-radius: var(--radius-md); overflow: hidden;">
                                <div
                                    style="background-color: #f59e0b; width: <?= ($solicitudes['TotalCR'] / $solicitudes['Total'] * 100) ?>%; height: 100%; border-radius: var(--radius-md); color: #fff; font-size: 1.25rem; padding: var(--spacing-8) var(--spacing-12);">
                                    <?= $this->Number->format($solicitudes['TotalCR']) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <p style="padding: var(--spacing-16) 0;">Las solicitudes van desde el
                <strong>
                    <?= $solicitudes['Oldest']->i18nFormat("d 'de' MMMM 'de' YYYY") ?>
                </strong>
                hasta el <strong>
                    <?= $solicitudes['Newest']->i18nFormat("d 'de' MMMM 'de' YYYY") ?>
                </strong>
            </p>
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

    <div class="col-md-3" id="card-programas" style="min-height: 150px;">
        <div class="content-card" style="height: 100%;">
            <h5><i class="fa-solid fa-radio"></i> Programas</h5>
            <div class="stat-loading"
                style="padding: var(--spacing-24); text-align: center; color: var(--color-muted-gray);">
                <i class="fa-solid fa-circle-notch fa-spin"></i> Cargando...
            </div>
        </div>
    </div>
</div>

<div class="row g-4" style="margin-top: var(--spacing-24);">
    <div class="col-md-6" id="card-bitacora" style="min-height: 150px;">
        <div class="content-card" style="height: 100%;">
            <h5><i class="fa-solid fa-file-contract"></i> Bitácora Hoy</h5>
            <div class="stat-loading"
                style="padding: var(--spacing-24); text-align: center; color: var(--color-muted-gray);">
                <i class="fa-solid fa-circle-notch fa-spin"></i> Cargando...
            </div>
        </div>
    </div>

    <div class="col-md-6" id="card-roles" style="min-height: 120px;">
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
        <h5><i class="fa-solid fa-radio"></i> Streaming</h5>
        <div style="padding: var(--spacing-16) 0;">
            <div style="font-size: 2.5rem; font-weight: bold; color: ${c.primary};">${data.totalListeners.toLocaleString()}</div>
            <div style="color: ${c.text};">oyentes en los últimos 7 días</div>
            <div style="margin-top: var(--spacing-16); font-size: 0.875rem; color: ${c.success};">
                <i class="fa-solid fa-arrow-up"></i> ${data.maxDay}
            </div>
            <div style="font-size: 0.75rem; color: ${c.text}; opacity: 0.7;">día con más conexiones</div>
        </div>
    `);

        loadCard('<?= $this->Url->build(['controller' => 'Dashboard', 'action' => 'getPendingRequests']) ?>', 'card-solicitudes', (data, c) => `
        <h5><i class="fa-solid fa-folder-open"></i> Solicitudes Pendientes</h5>
        <div style="padding: var(--spacing-16) 0;">
            <div style="font-size: 2.5rem; font-weight: bold; color: ${data.total > 0 ? c.warning : c.success};">${data.total}</div>
            <div style="color: ${c.text}; margin-bottom: var(--spacing-8);">sin atender</div>
            <div style="font-size: 0.9rem;">
                ${data.UnrecordedSpots > 0 ? `<div style="color: ${c.danger}; margin-bottom: var(--spacing-4);">
                    <i class="fa-solid fa-circle"></i> ${data.UnrecordedSpots} grabaciones pendientes
                </div>` : ''}
                ${data.UnnacceptedCeremonyMasters > 0 ? `<div style="color: ${c.warning};">
                    <i class="fa-solid fa-circle"></i> ${data.UnnacceptedCeremonyMasters} MC sin aceptar
                </div>` : ''}
            </div>
            ${data.total > 0 ? `<a href="<?= $this->Url->build(['controller' => 'Solicitudes', 'status' => 'pendiente']) ?>" style="color: ${c.primary}; margin-top: var(--spacing-16); display: block;">
                <i class="fa-solid fa-arrow-right"></i> Ver solicitudes
            </a>` : ''}
        </div>
    `);

        loadCard('<?= $this->Url->build(['controller' => 'Dashboard', 'action' => 'getOpenIncidences']) ?>', 'card-incidencias', (data, c) => `
        <h5><i class="fa-solid fa-file-signature"></i> Incidencias Abiertas</h5>
        <div style="padding: var(--spacing-16) 0;">
            <div style="font-size: 2.5rem; font-weight: bold; color: ${data.open > 0 ? c.danger : c.success};">${data.open}</div>
            <div style="color: ${c.text};">incidencias activas</div>
            ${data.open > 0 ? `<a href="<?= $this->Url->build(['controller' => 'Incidencias', 'status' => 'abierta']) ?>" style="color: ${c.primary}; margin-top: var(--spacing-16); display: block;">
                <i class="fa-solid fa-arrow-right"></i> Ver incidencias
            </a>` : ''}
        </div>
    `);

        loadCard('<?= $this->Url->build(['controller' => 'Dashboard', 'action' => 'getProgramsStats']) ?>', 'card-programas', (data, c) => `
        <h5><i class="fa-solid fa-computer"></i> Programas</h5>
        <div style="padding: var(--spacing-16) 0;">
            <div style="font-size: 2.5rem; font-weight: bold; color: ${c.primary};">${data.total}</div>
            <div style="color: ${c.text}; margin-bottom: var(--spacing-8);">programas al aire</div>
            <div style="font-size: 0.9rem;">
                <div style="color: ${c.success};"><i class="fa-solid fa-music"></i> ${data.musical} segmentos musicales</div>
                <div style="color: ${c.primary};"><i class="fa-solid fa-microphone"></i> ${data.spoken} programas hablados</div>
            </div>
            ${data.outOfAir > 0 ? `<div style="font-size: 0.9rem; color: ${c.danger};">
                <i class="fa-solid fa-circle-xmark"></i> ${data.outOfAir} fuera del aire
            </div>` : ''}
        </div>
    `);

        loadCard('<?= $this->Url->build(['controller' => 'Dashboard', 'action' => 'getBitacorasStats']) ?>', 'card-bitacora', (data, c) => `
        <h5><i class="fa-solid fa-file-contract"></i> Bitácora</h5>
        <div style="padding: var(--spacing-16) 0;">
            <div style="font-size: 2.5rem; font-weight: bold; color: ${c.primary};">${data.TodayCount}</div>
            <div style="color: ${c.text}; margin-bottom: var(--spacing-16);">registros hoy</div>
            <div style="font-size: 0.9rem;">
                <div style="color: ${c.success};"><i class="fa-solid fa-list"></i> ${data.TotalCount} registros en total</div>
                <div style="color: ${c.muted}; margin-top: var(--spacing-8);"><i class="fa-solid fa-calendar"></i> ${data.Oldest} hasta ${data.Newest}</div>
            </div>
            <a href="<?= $this->Url->build(['controller' => 'BitacoraCabina', 'action' => 'view']) ?>/${data.TodayID}" style="color: ${c.primary}; margin-top: var(--spacing-16); display: block;">
                <i class="fa-solid fa-arrow-right"></i> Ver bitácora
            </a>
        </div>
    `);

        loadCard('<?= $this->Url->build(['controller' => 'Dashboard', 'action' => 'getNextWeekRol']) ?>', 'card-roles', (data, c) => `
        <h5><i class="fa-solid fa-microphone-lines"></i> Roles de Cabina</h5>
        <div style="padding: var(--spacing-16) 0;">
            ${data.existe
                ? `<div style="color: ${c.success};"><i class="fa-solid fa-check-circle"></i> El rol para la semana del ${data.semanaInicio} al ${data.semanaFin} ya está registrado</div>`
                + `<a href="<?= $this->Url->build(['controller' => 'Roles', 'action' => 'view']) ?>/${data.rolID}" style="color: ${c.primary}; margin-top: var(--spacing-16); display: block;">
                <i class="fa-solid fa-arrow-right"></i> Ver rol de cabina
            </a>`


                : `<div style="color: ${c.warning};"><i class="fa-solid fa-exclamation-circle"></i> No se ha registrado rol de cabina para la próxima semana</div>
                   <a href="<?= $this->Url->build(['controller' => 'Roles', 'action' => 'add']) ?>" style="color: ${c.primary}; margin-top: var(--spacing-16); display: inline-block;">
                       <i class="fa-solid fa-plus"></i> Crear Rol de Cabina
                   </a>`
            }
        </div>
    `);
    }

    document.addEventListener('DOMContentLoaded', loadDashboardCards);
</script>

<div style="text-align: right; padding: var(--spacing-24); color:var(--color-border-light);">
    <?= $datetime->i18nFormat(IntlDateFormatter::FULL) ?>
</div>