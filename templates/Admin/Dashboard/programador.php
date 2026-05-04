<div class="page-header">
    <h3>Bienvenido, <?= $user->name ?></h3>
</div>

<div class="content-card" style="padding: var(--spacing-24);">
    <div class="row g-4">
        <div class="col-md-4" style="padding: var(--spacing-16);">
            <h5><i class="fa-solid fa-bell"></i> Estado del sistema</h5>
            
            <div class="alert alert-success" style="padding: var(--spacing-16); margin-top: var(--spacing-16);">
                <h5>Sin novedad</h5>
                <p>Todo marcha a la perfección.</p>
            </div>
        </div>
        
        <div class="col-md-8" style="padding: var(--spacing-16);">
            <h5><i class="fa-solid fa-chart-simple"></i> Estadísticas</h5>
            
            <p style="padding: var(--spacing-16) 0;">Hay <strong><?= $solicitudes['Total'] ?></strong> solicitudes registradas en el sistema.</p>
            
            <div class="row g-3" style="padding: var(--spacing-16) 0;">
                <div class="col-md-5">
                    <div style="border-left: 4px solid #9333ea; padding-left: var(--spacing-16); margin-bottom: var(--spacing-20);">
                        <div style="color: var(--color-faded-silver);">Grabaciones de spot</div>
                        <strong style="font-size: 1.5rem;"><?= $this->Number->format($solicitudes['TotalGDS']) ?></strong>
                    </div>
                    
                    <div style="border-left: 4px solid #22c55e; padding-left: var(--spacing-16); margin-bottom: var(--spacing-20);">
                        <div style="color: var(--color-faded-silver);">Maestros de ceremonia</div>
                        <strong style="font-size: 1.5rem;"><?= $this->Number->format($solicitudes['TotalMDC']) ?></strong>
                    </div>
                    
                    <div style="border-left: 4px solid #f59e0b; padding-left: var(--spacing-16);">
                        <div style="color: var(--color-faded-silver);">Controles remotos</div>
                        <strong style="font-size: 1.5rem;"><?= $this->Number->format($solicitudes['TotalCR']) ?></strong>
                    </div>
                </div>
                
                <div class="col-md-7" style="padding: var(--spacing-16);">
                    <div style="background-color: var(--color-subtle-gray); margin-bottom: var(--spacing-12); border-radius: var(--radius-md);">
                        <div style="background-color: #9333ea; padding: var(--spacing-12); width: <?= ($solicitudes['TotalGDS'] / $solicitudes['Total'] * 100) ?>%; border-radius: var(--radius-md);">
                            <?= $this->Number->format($solicitudes['TotalGDS']) ?>
                        </div>
                    </div>
                    
                    <div style="background-color: var(--color-subtle-gray); margin-bottom: var(--spacing-12); border-radius: var(--radius-md);">
                        <div style="background-color: #22c55e; padding: var(--spacing-12); width: <?= ($solicitudes['TotalMDC'] / $solicitudes['Total'] * 100) ?>%; border-radius: var(--radius-md);">
                            <?= $this->Number->format($solicitudes['TotalMDC']) ?>
                        </div>
                    </div>
                    
                    <div style="background-color: var(--color-subtle-gray); margin-bottom: var(--spacing-12); border-radius: var(--radius-md);">
                        <div style="background-color: #f59e0b; padding: var(--spacing-12); width: <?= ($solicitudes['TotalCR'] / $solicitudes['Total'] * 100) ?>%; border-radius: var(--radius-md);">
                            <?= $this->Number->format($solicitudes['TotalCR']) ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <hr style="margin: var(--spacing-24) 0; border-color: var(--color-border);">
            
            <p style="padding: var(--spacing-12) 0;">Hay <strong><?= $bitacoras['Total'] ?></strong> registros diarios en la Bitácora de Cabina.</p>
            <p style="padding: var(--spacing-8) 0;">Los registros van desde el <strong><?= $bitacoras['FirstOne']->i18nFormat(IntlDateFormatter::LONG) ?></strong> hasta el <strong><?= $bitacoras['LastOne']->i18nFormat(IntlDateFormatter::LONG) ?></strong>.</p>
            <p style="padding: var(--spacing-8) 0;">Abarcando un período de <strong><?= $bitacorasDiff ?></strong>.</p>

            <p style="padding: var(--spacing-16) 0;">En estos registros se detalla el cumplimiento de los <strong><?= $programas['Total'] ?></strong> programas que hay al aire.</p>
        </div>
    </div>
</div>

<div style="text-align: right; padding: var(--spacing-24); color: var(--color-faded-silver);">
    <?= $time->i18nFormat(IntlDateFormatter::FULL) ?>
</div>