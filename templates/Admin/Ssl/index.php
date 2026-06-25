<?php
/**
 * @var \App\View\AppView $this
 * @var string|null $domain
 * @var \SPC\Model\DTO\Certificate $certInfo
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

    <?php if ($renewLog): ?>
    <details class="alert alert-danger" style="margin-bottom:1rem;white-space:pre-wrap;font-size:0.85rem;" open>
        <summary style="cursor:pointer;font-weight:bold;">
            <i class="fa-solid fa-circle-exclamation"></i> Log de la última renovación
        </summary>
        <div style="margin-top:0.5rem;background:#1a1a2e;color:#e0e0e0;padding:0.75rem;border-radius:4px;font-family:monospace;">
            <?= implode("\n", $renewLog) ?>
        </div>
    </details>
    <?php endif; ?>

        <?php
        $daysLeft = $certInfo->daysLeft;
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

        <div class="page-subheader mt-3">
            <h5>Información del certificado</h5>
        </div>
        <table class="view-table">
            <tr>
                <th>Dominio</th>
                <td><?= $domain ?></td>
            </tr>
            <tr>
                <th>Subject</th>
                <td><?= $certInfo->subject ?></td>
            </tr>
            <tr>
                <th>Issuer</th>
                <td><?= $certInfo->issuer ?></td>
            </tr>
            <tr>
                <th>Expira</th>
                <td><?= $certInfo->expiry->i18nFormat(IntlDateFormatter::FULL) ?></td>
            </tr>
            <?php if ($certInfo->sans !== []): ?>
            <tr>
                <th>SANs</th>
                <td><?= implode(', ', $certInfo->sans) ?></td>
            </tr>
            <?php endif; ?>
            <tr>
                <th>Última renovación</th>
                <td><?= $certInfo->lastRenew->i18nFormat(IntlDateFormatter::FULL) ?></td>
            </tr>
        </table>

        <div class="page-subheader">
            <h5>Archivos</h5>
        </div>
        <table class="view-table">
            <tr>
                <th>Certificado</th>
                <td>
                <?= $certInfo->certFile ?>
                <?= $this->Html->link(
                    '<i class="fa-solid fa-download"></i>',
                    ['action' => 'download', '?' => ['type' => 'cert']],
                    ['escapeTitle' => false, 'class' => 'btn-ghost', 'title' => 'Descargar .cer']
                ) ?>
                </td>
            </tr>
            <tr>
                <th>Fullchain</th>
                <td>
                    <?= $certInfo->fullchainFile ?>
                    <?= $this->Html->link(
                        '<i class="fa-solid fa-download"></i>',
                        ['action' => 'download', '?' => ['type' => 'fullchain']],
                        ['escapeTitle' => false, 'class' => 'btn-ghost', 'title' => 'Descargar fullchain.cer']
                    ) ?>
                </td>
            </tr>
            <tr>
                <th>Llave privada</th>
                <td>
                    <?= $certInfo->keyFile ?>
                    <?= $this->Html->link(
                        '<i class="fa-solid fa-download"></i>',
                        ['action' => 'download', '?' => ['type' => 'key']],
                        ['escapeTitle' => false, 'class' => 'btn-ghost', 'title' => 'Descargar .key']
                    ) ?>
                </td>
            </tr>
            <tr>
                <th>PFX</th>
                <td>
                    <?= $certInfo->pfxFile ?>
                    <?php if ($certInfo->pfxExists): ?>
                        <span class="status-badge status-completed">Generado</span>
                        <?= $this->Html->link(
                            '<i class="fa-solid fa-download"></i>',
                            ['action' => 'download', '?' => ['type' => 'pfx']],
                            ['escapeTitle' => false, 'class' => 'btn-ghost', 'title' => 'Descargar .pfx']
                        ) ?>
                    <?php else: ?>
                        <span class="status-badge status-pending">Pendiente</span>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <th>PFX generado</th>
                <td><?= $certInfo->pfxAge->i18nFormat(IntlDateFormatter::FULL) ?></td>
            </tr>
            <tr>
                <th>Contraseña</th>
                <td><?= $ssl->getPfxPassword() ?></td>
            </tr>
        </table>

        <div class="actions-bar">
            <?= $this->Form->postButton(
                '<i class="fa-solid fa-rotate"></i> Renovar ahora',
                ['action' => 'renew'],
                [
                    'class' => 'btn btn-primary',
                    'escapeTitle' => false,
                    'confirm' => '¿Renovar certificado para ' . $domain . '? Se generará un nuevo PFX',
                ]
            ) ?>
        </div>
</div>
