<div class="content">
	<div class="w3-dark-golden w3-padding">
		<h1>Solicitudes</h1>
	</div>
	
	<div class="w3-container">
		 <?= $this->Html->link('<i class="fa-solid fa-file-arrow-up"></i> Registrar una solicitud nueva', ['action' => 'add'], ['class' => 'w3-button w3-golden w3-hover-dark-golden w3-right w3-section', 'escape' => false]) ?>
	</div>


    <div class="table-responsive">
		<ul class="w3-ul">
			<?php foreach ($solicitudes as $solicitud): ?>
			<li class="w3-display-container">
				<div class="w3-display-topleft"><h4><?= $this->Html->link($solicitud->solicitante, ['action' => 'view', $solicitud->ID]) ?></h4></div>
				<div class="w3-display-left">
					<?= $solicitud->tipoSolicitud ?>
					<p><?= $this->Html->link($solicitud->evento, ['action' => 'view', $solicitud->ID]) ?></p>
				</div>
				<div class="w3-display-bottomleft id">Solicitud #<?= $solicitud->ID ?></div>
				
				<div class="w3-display-middle">
					
				</div>
				<div class="w3-display-bottommiddle"><?= $solicitud->getStatus() ?></div>
				
				<div class="w3-display-topright"><?= h($solicitud->fecha) ?></div>
				<div class="w3-display-bottomright"><?= $solicitud->alreadyAccepted() ?></div>


			</li>
			<?php endforeach; // $solicitud->primerAsignado?>
        </ul>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>

<style>
	ul li{min-height:180px;margin:0;} .w3-display-left i.fa-solid{font-size:72px;padding-top:32px;float:left;} li p{padding:32px 0 12px 72px;}
	.w3-badge{width:24px;height:24px;} .w3-display-bottommiddle i{font-size:24px;padding:12px;}
	.w3-display-container div{padding:0 12px;}
	.w3-display-left{margin:4px 0;}
	.w3-display-topleft{padding:0;}
	li:nth-child(odd) {background: #efefef;} li:nth-child(even) {  background: #fff;}
	li:nth-child(odd) .id {color:#fff;} li:nth-child(even) .id {color:#ddd;}
</style>