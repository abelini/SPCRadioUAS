<?php
/**
 * @var \App\View\AppView $this
 * @var array $status
 * @var array|null $override
 */
$this->assign('title', 'Monitor RDS');
$fmt = fn(?string $v) => htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8');
?>
<style>
.rds-panel {
  max-width: 580px;
  margin: 0 auto 2rem;
}
.rds-display {
  background: #111;
  border: 3px solid #444;
  border-radius: 14px;
  padding: 20px 24px;
  box-shadow: 0 0 20px rgba(0,255,0,.08), inset 0 0 30px rgba(0,0,0,.6);
  font-family: 'Courier New', 'JetBrains Mono', monospace;
  color: #0f0;
  text-shadow: 0 0 6px rgba(0,255,0,.4);
  position: relative;
}
.rds-frequency {
  text-align: center;
  font-size: 13px;
  letter-spacing: 3px;
  color: #f80;
  text-shadow: 0 0 8px rgba(255,136,0,.5);
  margin-bottom: 10px;
  text-transform: uppercase;
  font-weight: 700;
}
.rds-screen {
  background: #0a0a0a;
  border: 1px solid #333;
  border-radius: 6px;
  padding: 14px 16px;
  min-height: 140px;
}
.rds-line { font-size: 15px; line-height: 1.7; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.rds-line.lg { font-size: 20px; }
.rds-line.dim { opacity: .6; font-size: 13px; }
.rds-line.green { color: #0f0; }
.rds-line.amber { color: #fa0; }
.rds-line.cyan  { color: #0ff; }
.rds-line.gray  { color: #888; }
.rds-indicator {
  display: inline-block;
  width: 10px; height: 10px;
  border-radius: 50%;
  margin-right: 6px;
}
.rds-indicator.on  { background: #0f0; box-shadow: 0 0 8px #0f0; }
.rds-indicator.off { background: #f00; box-shadow: 0 0 8px #f00; }
.rds-footer {
  margin-top: 10px;
  font-size: 11px;
  color: #666;
  text-align: center;
}
.form-override {
  max-width: 580px;
  margin: 0 auto;
}
.form-override fieldset {
  border: 1px solid var(--color-border-light, #d0d7de);
  border-radius: var(--radius-md, 6px);
  padding: 1rem 1.2rem;
  margin-bottom: 1rem;
}
.form-override legend {
  font-weight: 600;
  padding: 0 8px;
}
.form-row {
  display: flex;
  gap: 12px;
  margin-bottom: 10px;
  align-items: center;
}
.form-row label {
  min-width: 100px;
  font-weight: 500;
}
.form-row input, .form-row select {
  flex: 1;
  padding: 6px 8px;
  border: 1px solid var(--color-border-light, #d0d7de);
  border-radius: var(--radius-input, 6px);
  background: var(--color-canvas, #fff);
  color: var(--color-ink, #1f2328);
}
.form-row input[type="number"] { flex: 0 0 80px; }
.form-row select { flex: 0 0 140px; }
.form-actions {
  display: flex;
  gap: 10px;
  margin-top: 14px;
}
.override-banner {
  background: #fff3cd;
  border: 1px solid #ffc107;
  border-radius: var(--radius-md, 6px);
  padding: 10px 14px;
  margin-bottom: 1rem;
  font-size: 14px;
  color: #856404;
}
</style>

<div class="rds-panel">
  <div class="rds-display">
    <div class="rds-frequency">— FM 96.1 MHz —</div>
    <div class="rds-screen">
      <?php if (!empty($status['connected'])): ?>
        <div class="rds-line lg green"><?= $fmt($status['rt'] ?: '—') ?></div>
        <div class="rds-line amber"><?= $fmt($status['ps'] ?: '—') ?></div>
        <div class="rds-line dim">
          PTY: <?= $fmt($status['pty']) ?>
          &nbsp;&nbsp;|&nbsp;&nbsp;
          <?= ($status['xfms'] ?? '0') === '1' ? 'MÚSICA' : 'HABLA' ?>
        </div>
        <div class="rds-line gray">PTN: <?= $fmt($status['ptn'] ?: '—') ?></div>
        <div class="rds-line gray">FW: <?= $fmt($status['version'] ?: '—') ?></div>
        <div class="rds-line dim" style="margin-top:4px">
          <span class="rds-indicator on"></span> CONECTADO
        </div>
      <?php else: ?>
        <div class="rds-line dim">
          <span class="rds-indicator off"></span> DESCONECTADO
        </div>
        <div class="rds-line gray"><?= $fmt($status['error'] ?? 'Error desconocido') ?></div>
      <?php endif; ?>
    </div>
    <div class="rds-footer">
      Última actualización: <?= date('H:i:s') ?>
    </div>
  </div>
</div>

<?php if ($override !== null): ?>
<div class="override-banner" style="max-width:580px;margin:0 auto 1rem">
  ⚠️ Override activo hasta las <?= date('H:i', $override['expires_at'] ?? time()) ?>
  — <a href="?cancel=1" style="font-weight:600">Cancelar override</a>
</div>
<?php endif; ?>

<div class="form-override">
  <?= $this->Form->create(null, ['url' => ['action' => 'index'], 'type' => 'post']) ?>
  <fieldset>
    <legend>Sobrescribir RDS</legend>

    <div class="form-row">
      <label for="ps">PS (estático)</label>
      <input type="text" name="ps" id="ps" maxlength="8" value="<?= $fmt($override['ps'] ?? 'RADIOUAS') ?>">
    </div>

    <div class="form-row">
      <label for="rt">RT (radiotexto)</label>
      <input type="text" name="rt" id="rt" maxlength="64" value="<?= $fmt($override['rt'] ?? '') ?>">
    </div>

    <div class="form-row">
      <label for="pty">PTY (0–31)</label>
      <input type="number" name="pty" id="pty" min="0" max="31" value="<?= (int) ($override['pty'] ?? 0) ?>">
    </div>

    <div class="form-row">
      <label for="music">Tipo</label>
      <select name="music" id="music">
        <option value="1" <?= (!empty($override['music'])) ? 'selected' : '' ?>>Música</option>
        <option value="0" <?= (empty($override['music'])) ? 'selected' : '' ?>>Habla</option>
      </select>
    </div>

    <div class="form-row">
      <label for="ptn">PTN</label>
      <input type="text" name="ptn" id="ptn" maxlength="8" value="<?= $fmt($override['ptn'] ?? '') ?>">
    </div>

    <div class="form-row">
      <label for="duration_value">Duración</label>
      <input type="number" name="duration_value" id="duration_value" min="1" max="999" value="30" required>
      <select name="duration_unit" id="duration_unit">
        <option value="minutes">Minutos</option>
        <option value="hours">Horas</option>
      </select>
    </div>
  </fieldset>

  <div class="form-actions">
    <button type="submit" class="btn btn-primary">Aplicar override</button>
    <?php if ($override !== null): ?>
      <a href="?cancel=1" class="btn btn-secondary" style="padding:6px 14px;border:1px solid var(--color-border-light,#d0d7de);border-radius:var(--radius-input,6px);text-decoration:none">Cancelar override</a>
    <?php endif; ?>
  </div>
  <?= $this->Form->end() ?>
</div>
