<?php
/**
 * @var \App\View\AppView $this
 * @var array $status
 * @var array|null $override
 */
use SPC\Model\Enum\PTY;

$this->assign('title', 'Monitor RDS');

?>
<link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@400;600;700&display=swap" rel="stylesheet">
<style>
.rds-panel {
  max-width: 960px;
  margin: 0 auto 2rem;
}
.rds-display {
  background: #111;
  border: 5px solid #444;
  border-radius: 24px;
  padding: 36px 42px;
  box-shadow: 0 0 36px rgba(0,255,0,.08), inset 0 0 50px rgba(0,0,0,.6);
  font-family: 'Exo 2', 'Courier New', monospace;
  color: #0f0;
  text-shadow: 0 0 10px rgba(0,255,0,.4);
  position: relative;
}
.rds-frequency {
  text-align: center;
  font-size: 22px;
  letter-spacing: 5px;
  color: #f80;
  text-shadow: 0 0 14px rgba(255,136,0,.5);
  margin-bottom: 18px;
  text-transform: uppercase;
  font-weight: 700;
}
.rds-screen {
  background: #0a0a0a;
  border: 2px solid #333;
  border-radius: 10px;
  padding: 24px 28px;
  min-height: 240px;
}
.rds-line { font-size: 26px; line-height: 1.7; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.rds-line.rt  { font-size: 48px; }
.rds-line.ps  { font-size: 36px; }
.rds-line.sm  { font-size: 22px; }
.rds-line.dim { opacity: .6; font-size: 22px; }
.rds-line.gr20 { font-size: 20px; color: #888; }
.rds-marquee {
  overflow: hidden;
  white-space: nowrap;
}
.rds-marquee span {
  display: inline-block;
  animation: marquee 35s linear infinite;
}
@keyframes marquee {
  0% { transform: translateX(100%); }
  5% { transform: translateX(0); }
  95% { transform: translateX(0); }
  100% { transform: translateX(-100%); }
}
.rds-line.green { color: #0f0; }
.rds-line.amber { color: #fa0; }
.rds-line.cyan  { color: #0ff; }
.rds-line.gray  { color: #888; }
.rds-indicator {
  display: inline-block;
  width: 18px; height: 18px;
  border-radius: 50%;
  margin-right: 10px;
}
.rds-indicator.on  { background: #0f0; box-shadow: 0 0 14px #0f0; }
.rds-indicator.off { background: #f00; box-shadow: 0 0 14px #f00; }
.rds-footer {
  margin-top: 18px;
  font-size: 18px;
  color: #666;
  text-align: center;
}
.form-override {
  max-width: 960px;
  margin: 0 auto;
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
        <div class="rds-line rt green rds-marquee"><span><?= $status['rt'] ?: '—' ?></span></div>
        <div class="rds-line ps amber"><?= $status['ps'] ?: '—' ?></div>
        <div class="rds-line sm">
          PTY: <?= PTY::tryFrom($status['pty'])?->name ?>&nbsp;&nbsp;|&nbsp;&nbsp;<?= ($status['xfms'] ?? '0') === '1' ? 'MÚSICA' : 'HABLA' ?>
        </div>
        <div class="rds-line sm">PTN: <?= $status['ptn'] ?: '—' ?></div>
        <div class="rds-line gr20" style="display:flex;justify-content:space-between">
          <span>PI: <?= $status['pic'] ?: '—' ?></span>
          <span>IDF: <?= $status['idf'] ?: '—' ?></span>
          <span>FW: <?= $status['version'] ?: '—' ?></span>
        </div>
        <div class="rds-line dim" style="margin-top:4px">
          <span class="rds-indicator on"></span> CONECTADO
        </div>
      <?php else: ?>
        <div class="rds-line dim">
          <span class="rds-indicator off"></span> DESCONECTADO
        </div>
        <div class="rds-line gray"><?= $status['error'] ?? 'Error desconocido' ?></div>
      <?php endif; ?>
    </div>
    <div class="rds-footer">
      Última actualización: <?= date('H:i:s') ?>
    </div>
  </div>
</div>

<?php if ($override !== null): ?>
<div class="override-banner" style="max-width:960px;margin:0 auto 1rem">
  ⚠️ Override activo hasta las <?= date('H:i', $override['expires_at'] ?? time()) ?>
  — <a href="?cancel=1" style="font-weight:600">Cancelar override</a>
</div>
<?php endif; ?>

<div class="form-override">

  <?= $this->Form->create(null, ['url' => ['action' => 'index'], 'type' => 'post']);?>

    <h3 class="form-group">Sobrescribir RDS</h3>

    <div class="form-group">
      <?= $this->Form->label('ps', 'PS (Program Service)') ?>
      <?= $this->Form->text('ps', ['value' => 'RADIOUAS', 'readonly' => 'readonly', 'class' => 'form-control', 'maxlength' => 8]) ?>
    </div>

    <div class="form-group">
      <?= $this->Form->label('rt', 'RT (RadioText)') ?>
      <?= $this->Form->text('rt', ['class' => 'form-control', 'maxlength' => 64]) ?>
    </div>

    <div class="form-group">
      <?= $this->Form->label('pty', 'PTY (Program Type)') ?>
      <?= $this->Form->select('pty', array_column(PTY::cases(), 'name'), ['class' => 'form-control', 'default' => 2]) ?>
    </div>

    <div class="form-group">
      <?= $this->Form->label('music', 'Bandera XFMS (Música o Hablado)') ?>
      <?= $this->Form->select('music', [1 => 'Music', 0 => 'Speech'], ['class' => 'form-control', 'default' => 1]) ?>
    </div>

    <div class="form-group">
      <?= $this->Form->label('ptn', 'PTN (Program Type Name)') ?>
      <?= $this->Form->text('ptn', ['class' => 'form-control', 'maxlength' => 8]) ?>
    </div>

    <div class="form-group">
      <?= $this->Form->label('duration_minutes', 'Duración (minutos)') ?>
      <?= $this->Form->number('duration_minutes', ['class' => 'form-control', 'min' => 1, 'max' => 999, 'default' => 30]) ?>
    </div>


  <div class="form-group">
    <?= $this->Form->button('Sobreescribir datos del RDS', ['class' => 'btn btn-primary']) ?>
    <?php if ($override !== null): ?>
      <?= $this->Html->link('Cancelar la sobreescritura de los datos', ['action' => 'index', '?' => ['cancel' => 1]], ['class' => 'btn btn-secondary']) ?>
    <?php endif; ?>
  </div>
  <?= $this->Form->end() ?>
</div>
