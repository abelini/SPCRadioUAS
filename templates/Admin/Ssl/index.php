<?php
/**
 * @var \App\View\AppView $this
 * @var string|null $domain
 * @var array|null $certInfo
 * @var bool $configured
 * @var bool $canRunAcme
 * @var string $dnsProvider
 * @var \SPC\Service\SslService $ssl
 * @var array $renewLog
 */
$this->assign('title', 'Certificado SSL');
?>
<div class="page-header">
    <h5><i class="fa-solid fa-shield-halved"></i> Certificado SSL</h5>
</div>
<div class="content-card">

    <?php
    $renewLog = $renewLog ?? $this->request->getSession()->consume('SslRenewLog');
    if ($renewLog):
    ?>
    <details class="alert alert-danger" style="margin-bottom:1rem;white-space:pre-wrap;font-size:0.85rem;" open>
        <summary style="cursor:pointer;font-weight:bold;">
            <i class="fa-solid fa-circle-exclamation"></i> Log de la última renovación
        </summary>
        <div style="margin-top:0.5rem;background:#1a1a2e;color:#e0e0e0;padding:0.75rem;border-radius:4px;font-family:monospace;">
            <?= h(implode("\n", $renewLog)) ?>
        </div>
    </details>
    <?php endif; ?>

    <?php if (!$configured): ?>
        <div class="alert alert-warning">
            <i class="fa-solid fa-triangle-exclamation"></i>
            No hay dominio configurado. Agrega <code>SslRenew.domain</code> en <code>config/app_local.php</code>.
        </div>

    <?php elseif (!$ssl->isAcmeInstalled() && $certInfo === null): ?>
        <div class="alert alert-warning">
            <i class="fa-solid fa-triangle-exclamation"></i>
            <strong>acme.sh no está instalado.</strong>
            Conéctate por SSH al servidor y ejecuta:<br>
            <code>curl -sL https://get.acme.sh | sh</code><br>
            Después de instalar, <a href="<?= $this->Url->build(['action' => 'index']) ?>">recarga esta página</a>.
        </div>

        <div class="stats-section">
            <div class="page-subheader">
                <h5>Configuración</h5>
            </div>
            <table class="view-table">
                <tr><th>Dominio</th><td><?= h($domain) ?></td></tr>
                <tr><th>Email</th><td><?= h($ssl->getEmail()) ?></td></tr>
                <tr><th>Destino PFX</th><td><?= h($ssl->getPfxDestination() ?? '(no configurado)') ?></td></tr>
                <tr><th>Contraseña PFX</th><td><?= $ssl->getPfxPassword() !== '' ? '******' : '<span class="badge-dot badge-dot-danger"></span> vacía' ?></td></tr>
                <tr><th>Método DNS</th><td><?= h($dnsProvider) ?></td></tr>
            </table>
        </div>

    <?php elseif ($certInfo && $certInfo['exists']): ?>
        <?php
        $daysLeft = $certInfo['daysLeft'];
        if ($daysLeft > 30) {
            $dotClass = 'status-dot-success';
            $statusText = 'Vigente';
            $badgeClass = 'status-completed';
        } elseif ($daysLeft > 7) {
            $dotClass = 'status-dot-warning';
            $statusText = 'Por vencer';
            $badgeClass = 'status-progress';
        } elseif ($daysLeft > 0) {
            $dotClass = 'status-dot-danger';
            $statusText = 'Vence pronto';
            $badgeClass = 'status-pending';
        } else {
            $dotClass = 'status-dot-danger';
            $statusText = 'Vencido';
            $badgeClass = 'status-pending';
        }
        ?>

        <div class="row g-3">
            <div class="col-md-6">
                <span class="status-dot <?= $dotClass ?>"></span>
                <strong><?= $statusText ?></strong>
            </div>
            <div class="col-md-6">
                <?php if ($daysLeft !== null): ?>
                    <span class="status-badge <?= $badgeClass ?>">
                        <i class="fa-regular fa-calendar"></i> <?= $daysLeft ?> días
                    </span>
                <?php endif; ?>
            </div>
        </div>

        <div class="page-subheader">
            <h5>Información del certificado</h5>
        </div>
        <table class="view-table">
            <tr><th>Dominio</th><td><?= h($domain) ?></td></tr>
            <tr><th>Subject</th><td><?= h($certInfo['subject'] ?? '—') ?></td></tr>
            <tr><th>Issuer</th><td><?= h($certInfo['issuer'] ?? '—') ?></td></tr>
            <tr><th>Expira</th><td><?= h($certInfo['expiry'] ?? '—') ?></td></tr>
            <?php if (!empty($certInfo['sans'])): ?>
            <tr><th>SANs</th><td><?= h(implode(', ', $certInfo['sans'])) ?></td></tr>
            <?php endif; ?>
            <tr><th>Última renovación</th><td><?= $certInfo['lastRenew'] ? date('Y-m-d H:i:s', $certInfo['lastRenew']) : '—' ?></td></tr>
        </table>

        <div class="page-subheader">
            <h5>Archivos</h5>
        </div>
        <table class="view-table">
            <tr><th>Certificado</th><td>
                <?= h($certInfo['certFile']) ?>
                <?= $this->Html->link(
                    '<i class="fa-solid fa-download"></i>',
                    ['action' => 'download', '?' => ['type' => 'cert']],
                    ['escapeTitle' => false, 'class' => 'btn-ghost', 'title' => 'Descargar .cer']
                ) ?>
            </td></tr>
            <tr><th>Fullchain</th><td>
                <?= h($certInfo['fullchainFile']) ?>
                <?= $this->Html->link(
                    '<i class="fa-solid fa-download"></i>',
                    ['action' => 'download', '?' => ['type' => 'fullchain']],
                    ['escapeTitle' => false, 'class' => 'btn-ghost', 'title' => 'Descargar fullchain.cer']
                ) ?>
            </td></tr>
            <tr><th>Llave privada</th><td>
                <?= h($certInfo['keyFile']) ?>
                <?= $this->Html->link(
                    '<i class="fa-solid fa-download"></i>',
                    ['action' => 'download', '?' => ['type' => 'key']],
                    ['escapeTitle' => false, 'class' => 'btn-ghost', 'title' => 'Descargar .key']
                ) ?>
            </td></tr>
            <tr><th>PFX</th><td>
                <?= h($certInfo['pfxFile']) ?>
                <?php if ($certInfo['pfxExists']): ?>
                    <span class="status-badge status-completed">Generado</span>
                    <?= $this->Html->link(
                        '<i class="fa-solid fa-download"></i>',
                        ['action' => 'download', '?' => ['type' => 'pfx']],
                        ['escapeTitle' => false, 'class' => 'btn-ghost', 'title' => 'Descargar .pfx']
                    ) ?>
                <?php else: ?>
                    <span class="status-badge status-pending">Pendiente</span>
                <?php endif; ?>
            </td></tr>
            <?php if ($certInfo['pfxExists'] && $certInfo['pfxAge']): ?>
            <tr><th>PFX generado</th><td><?= date('Y-m-d H:i:s', $certInfo['pfxAge']) ?></td></tr>
            <?php endif; ?>
            <tr><th>Contraseña</th><td><?= h($ssl->getPfxPassword()) ?></td></tr>
        </table>

        <?php if ($ssl->getPfxPassword() === ''): ?>
        <div class="alert alert-warning mt-3">
            <i class="fa-solid fa-triangle-exclamation"></i>
            La contraseña del PFX está vacía. Configura <code>SslRenew.pfxPassword</code> en <code>config/app_local.php</code> si el servicio destino la requiere.
        </div>
        <?php endif; ?>

        <?php if ($canRunAcme): ?>
        <div class="actions-bar">
            <?= $this->Form->postButton(
                '<i class="fa-solid fa-rotate"></i> Renovar ahora',
                ['action' => 'renew'],
                [
                    'class' => 'btn btn-primary',
                    'escapeTitle' => false,
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

        <div class="stats-section">
            <div class="page-subheader">
                <h5>Configuración</h5>
            </div>
            <table class="view-table">
                <tr><th>Destino PFX</th><td><?= h($certInfo['pfxFile'] ?? $ssl->getPfxDestination() ?? '(no configurado)') ?></td></tr>
                <tr><th>Contraseña PFX</th><td><?= $ssl->getPfxPassword() !== '' ? '******' : '<span class="badge-dot badge-dot-danger"></span> vacía' ?></td></tr>
                <tr><th>Método DNS</th><td><?= h($dnsProvider) ?></td></tr>
            </table>
        </div>

    <?php else: ?>
        <div class="alert alert-info">
            <i class="fa-solid fa-circle-info"></i>
            No se encontró un certificado existente para <strong><?= h($domain) ?></strong>.
        </div>

        <div class="stats-section">
            <div class="page-subheader">
                <h5>Configuración</h5>
            </div>
            <table class="view-table">
                <tr><th>Dominio</th><td><?= h($domain) ?></td></tr>
                <tr><th>Email</th><td><?= h($ssl->getEmail()) ?></td></tr>
                <tr><th>Destino PFX</th><td><?= h($ssl->getPfxDestination() ?? '(no configurado)') ?></td></tr>
                <tr><th>Contraseña PFX</th><td><?= $ssl->getPfxPassword() !== '' ? '******' : '<span class="badge-dot badge-dot-danger"></span> vacía' ?></td></tr>
                <tr><th>Método DNS</th><td><?= h($dnsProvider) ?></td></tr>
            </table>
        </div>

        <?php if ($canRunAcme): ?>
        <div class="actions-bar">
            <?= $this->Form->postButton(
                '<i class="fa-solid fa-rotate"></i> Obtener certificado',
                ['action' => 'renew'],
                ['class' => 'btn btn-primary', 'escapeTitle' => false]
            ) ?>
        </div>
        <?php endif; ?>
    <?php endif; ?>
</div>
