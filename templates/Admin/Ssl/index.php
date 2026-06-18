<?php
/**
 * @var \App\View\AppView $this
 * @var string|null $domain
 * @var array|null $certInfo
 * @var bool $configured
 * @var bool $canRunAcme
 * @var bool $isWindows
 * @var \SPC\Service\SslService $ssl
 */
$this->assign('title', 'Certificado SSL');
?>
<style>
.status-circle {
    display: inline-block;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    margin-right: 6px;
    vertical-align: middle;
}
.status-circle.green { background: var(--color-spring-green, #1a7f37); box-shadow: 0 0 6px var(--color-spring-green, #1a7f37); }
.status-circle.yellow { background: #d29922; box-shadow: 0 0 6px #d29922; }
.status-circle.red { background: #cf222e; box-shadow: 0 0 6px #cf222e; }
.status-circle.gray { background: var(--color-muted-gray, #656d76); }
.info-row {
    display: flex;
    justify-content: space-between;
    padding: 8px 0;
    border-bottom: 1px solid var(--color-border-subtle, #d0d7de);
    font-size: 14px;
}
.info-row:last-child { border-bottom: none; }
.info-row .label { color: var(--color-muted-gray, #656d76); font-weight: 500; }
.info-row .value { color: var(--color-dark-charcoal, #1f2328); text-align: right; word-break: break-all; }
.log-output {
    background: #0d1117;
    color: #8b949e;
    font-family: 'JetBrains Mono', 'Courier New', monospace;
    font-size: 12px;
    line-height: 1.6;
    padding: 16px;
    border-radius: 6px;
    max-height: 300px;
    overflow-y: auto;
    white-space: pre-wrap;
    word-break: break-all;
}
</style>

<div class="page-header">
    <h5><i class="fa-solid fa-shield-halved"></i> Certificado SSL</h5>
</div>
<div class="content-card">
    <?php if (!$canRunAcme): ?>
        <div class="alert alert-info">
            <i class="fa-solid fa-circle-info"></i>
            <strong>Entorno local detectado</strong>
            <?= $isWindows ? ' (Windows)' : '' ?>.
            La renovación automática con acme.sh solo funciona en el servidor de producción Linux.
            Aquí puedes ver la información del PFX que hayas copiado en <code>webroot/cert/</code>.
        </div>
    <?php endif; ?>

    <?php if (!$configured): ?>
        <div class="alert alert-warning">
            <i class="fa-solid fa-triangle-exclamation"></i>
            No hay dominio configurado. Agrega <code>SslRenew.domain</code> en <code>config/app_local.php</code>.
        </div>

    <?php elseif ($canRunAcme && !$ssl->isAcmeInstalled() && $certInfo === null): ?>
        <div class="alert alert-info">
            <i class="fa-solid fa-circle-info"></i>
            acme.sh no está instalado. Se instalará automáticamente al renovar.
        </div>

        <div class="stats-section" style="margin-top:0">
            <div class="page-subheader">
                <h5>Configuración</h5>
            </div>
            <div style="padding:16px 0">
                <div class="info-row">
                    <span class="label">Dominio</span>
                    <span class="value"><?= h($domain) ?></span>
                </div>
                <div class="info-row">
                    <span class="label">Email</span>
                    <span class="value"><?= h($ssl->getEmail()) ?></span>
                </div>
                <div class="info-row">
                    <span class="label">Destino PFX</span>
                    <span class="value"><?= h($ssl->getPfxDestination() ?? '(no configurado)') ?></span>
                </div>
                <div class="info-row">
                    <span class="label">Contraseña PFX</span>
                    <span class="value"><?= $ssl->getPfxPassword() !== '' ? '******' : '<span style="color:#cf222e">(vacia)</span>' ?></span>
                </div>
            </div>
        </div>

        <?php if ($canRunAcme): ?>
        <div style="margin-top:16px; text-align:center">
            <?= $this->Form->postButton(
                '<i class="fa-solid fa-rotate"></i> Instalar acme.sh y renovar',
                ['action' => 'renew'],
                ['class' => 'btn btn-primary', 'escape' => false]
            ) ?>
        </div>
        <?php endif; ?>

    <?php elseif ($certInfo && $certInfo['exists']): ?>
        <?php
        $daysLeft = $certInfo['daysLeft'];
        if ($daysLeft > 30) {
            $statusClass = 'green';
            $statusText = 'Vigente';
        } elseif ($daysLeft > 7) {
            $statusClass = 'yellow';
            $statusText = 'Por vencer';
        } elseif ($daysLeft > 0) {
            $statusClass = 'red';
            $statusText = 'Vence pronto';
        } else {
            $statusClass = 'red';
            $statusText = 'Vencido';
        }
        ?>

        <div style="display:flex; align-items:center; gap:24px; flex-wrap:wrap">
            <div style="display:flex; align-items:center; gap:12px">
                <span class="status-circle <?= $statusClass ?>"></span>
                <span style="font-size:16px; font-weight:600; color:var(--color-dark-charcoal)"><?= $statusText ?></span>
            </div>

            <?php if ($daysLeft !== null): ?>
                <span class="status-badge <?= $daysLeft > 30 ? 'status-completed' : ($daysLeft > 7 ? 'status-progress' : 'status-pending') ?>">
                    <i class="fa-regular fa-calendar"></i> <?= $daysLeft ?> días
                </span>
            <?php endif; ?>
        </div>

        <?php if ($certInfo['source'] === 'pfx'): ?>
        <div class="alert alert-info" style="margin-top:16px">
            <i class="fa-solid fa-circle-info"></i>
            Mostrando información del archivo PFX en <code><?= h($certInfo['pfxFile']) ?></code>.
            No hay certificado gestionado por acme.sh todavía. Presiona "Renovar" para obtener uno de Let's Encrypt.
        </div>
        <?php endif; ?>

        <div class="stats-section" style="margin-top:16px">
            <div class="page-subheader">
                <h5>Información del certificado</h5>
            </div>
            <div style="padding:16px 0">
                <div class="info-row">
                    <span class="label">Dominio</span>
                    <span class="value"><?= h($domain) ?></span>
                </div>
                <div class="info-row">
                    <span class="label">Subject</span>
                    <span class="value"><?= h($certInfo['subject'] ?? '—') ?></span>
                </div>
                <div class="info-row">
                    <span class="label">Issuer</span>
                    <span class="value"><?= h($certInfo['issuer'] ?? '—') ?></span>
                </div>
                <div class="info-row">
                    <span class="label">Expira</span>
                    <span class="value"><?= h($certInfo['expiry'] ?? '—') ?></span>
                </div>
                <?php if (!empty($certInfo['sans'])): ?>
                <div class="info-row">
                    <span class="label">SANs</span>
                    <span class="value" style="font-size:12px"><?= h(implode(', ', $certInfo['sans'])) ?></span>
                </div>
                <?php endif; ?>
                <div class="info-row">
                    <span class="label">Última renovación</span>
                    <span class="value"><?= $certInfo['lastRenew'] ? date('Y-m-d H:i:s', $certInfo['lastRenew']) : '—' ?></span>
                </div>
            </div>
        </div>

        <div class="stats-section">
            <div class="page-subheader">
                <h5>Archivos</h5>
            </div>
            <div style="padding:16px 0">
                <div class="info-row">
                    <span class="label">Certificado</span>
                    <span class="value" style="font-size:12px"><?= h($certInfo['certFile']) ?></span>
                </div>
                <div class="info-row">
                    <span class="label">Llave privada</span>
                    <span class="value" style="font-size:12px"><?= h($certInfo['keyFile']) ?></span>
                </div>
                <div class="info-row">
                    <span class="label">PFX</span>
                    <span class="value" style="font-size:12px">
                        <?= h($certInfo['pfxFile']) ?>
                        <?php if ($certInfo['pfxExists']): ?>
                            <span class="status-badge status-completed" style="margin-left:8px">Generado</span>
                        <?php else: ?>
                            <span class="status-badge status-pending" style="margin-left:8px">Pendiente</span>
                        <?php endif; ?>
                    </span>
                </div>
                <?php if ($certInfo['pfxExists'] && $certInfo['pfxAge']): ?>
                <div class="info-row">
                    <span class="label">PFX generado</span>
                    <span class="value"><?= date('Y-m-d H:i:s', $certInfo['pfxAge']) ?></span>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <?php if ($ssl->getPfxPassword() === ''): ?>
        <div class="alert alert-warning" style="margin-top:16px">
            <i class="fa-solid fa-triangle-exclamation"></i>
            La contraseña del PFX está vacía. Configura <code>SslRenew.pfxPassword</code> en <code>app_local.php</code> si el servicio destino la requiere.
        </div>
        <?php endif; ?>

        <?php if ($canRunAcme): ?>
        <div style="margin-top:24px; display:flex; gap:12px; flex-wrap:wrap">
            <?= $this->Form->postButton(
                '<i class="fa-solid fa-rotate"></i> Renovar ahora',
                ['action' => 'renew'],
                [
                    'class' => 'btn btn-primary',
                    'escape' => false,
                    'confirm' => '¿Renovar certificado para ' . h($domain) . '? Se generará un nuevo .pfx.',
                ]
            ) ?>
        </div>
        <?php endif; ?>

    <?php elseif ($certInfo !== null && $certInfo['error'] !== null): ?>
        <div class="alert alert-danger">
            <i class="fa-solid fa-circle-exclamation"></i>
            <?= h($certInfo['error']) ?>
        </div>

        <div class="stats-section" style="margin-top:0">
            <div class="page-subheader">
                <h5>Configuración</h5>
            </div>
            <div style="padding:16px 0">
                <div class="info-row">
                    <span class="label">Destino PFX</span>
                    <span class="value"><?= h($certInfo['pfxFile'] ?? $ssl->getPfxDestination() ?? '(no configurado)') ?></span>
                </div>
                <div class="info-row">
                    <span class="label">Contraseña PFX</span>
                    <span class="value"><?= $ssl->getPfxPassword() !== '' ? '******' : '<span style="color:#cf222e">(vacia)</span>' ?></span>
                </div>
            </div>
        </div>

    <?php else: ?>
        <div class="alert alert-info">
            <i class="fa-solid fa-circle-info"></i>
            No se encontró un certificado existente para <strong><?= h($domain) ?></strong>.
            Presiona "Renovar" para obtener el primero.
        </div>

        <div class="stats-section" style="margin-top:0">
            <div class="page-subheader">
                <h5>Configuración</h5>
            </div>
            <div style="padding:16px 0">
                <div class="info-row">
                    <span class="label">Dominio</span>
                    <span class="value"><?= h($domain) ?></span>
                </div>
                <div class="info-row">
                    <span class="label">Email</span>
                    <span class="value"><?= h($ssl->getEmail()) ?></span>
                </div>
                <div class="info-row">
                    <span class="label">Destino PFX</span>
                    <span class="value"><?= h($ssl->getPfxDestination() ?? '(no configurado)') ?></span>
                </div>
                <div class="info-row">
                    <span class="label">Contraseña PFX</span>
                    <span class="value"><?= $ssl->getPfxPassword() !== '' ? '******' : '<span style="color:#cf222e">(vacia)</span>' ?></span>
                </div>
            </div>
        </div>

        <?php if ($canRunAcme): ?>
        <div style="margin-top:16px; text-align:center">
            <?= $this->Form->postButton(
                '<i class="fa-solid fa-rotate"></i> Obtener certificado',
                ['action' => 'renew'],
                ['class' => 'btn btn-primary', 'escape' => false]
            ) ?>
        </div>
        <?php endif; ?>
    <?php endif; ?>
</div>
