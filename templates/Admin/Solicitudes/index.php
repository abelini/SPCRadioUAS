<div class="content">
	<div class="w3-deep-blue w3-padding">
		<h5><i class="fa-solid fa-folder-open"></i> Solicitudes</h5>
	</div>

    <div class="table-responsive">
		<ul class="w3-ul">
			<?php foreach ($solicitudes as $solicitud): ?>
			<li class="w3-display-container">
				<div class="w3-display-topleft"><h5><?= $this->Html->link($solicitud->solicitante, ['action' => 'view', $solicitud->ID]) ?></h5></div>
				<div class="w3-display-left">
					<?= $solicitud->tipoSolicitud ?>
					<p><?= $this->Html->link($solicitud->evento, ['action' => 'view', $solicitud->ID]) ?></p>
				</div>
				<div class="w3-display-bottomleft id">Solicitud #<?= $solicitud->ID ?></div>
				
				<div class="w3-display-middle">
					
				</div>
				<div class="w3-display-bottommiddle"><?= $solicitud->getStatus() ?></div>
				
				<div class="w3-display-topright">
					<h5><?= str_replace(':00 ', '', $solicitud->fecha->i18nFormat("d MMM YYYY, h:mm aaa"/*\IntlDateFormatter::MEDIUM*/)) ?></h5>
				</div>
				<div class="w3-display-bottomright"><?= $solicitud->alreadyAccepted() ?></div>


			</li>
			<?php endforeach; // $solicitud->primerAsignado?>
        </ul>
    </div>
    
    

	<div class="w3-center w3-padding-48">
		<div class="w3-bar w3-border">
		<?= $this->Paginator->first('<i class="fa-solid fa-angles-left"></i>', ['escape' => false]) ?>
		<?= $this->Paginator->prev('<i class="fa-solid fa-angle-left"></i>', ['escape' => false]) ?>
		<?= $this->Paginator->numbers() ?>
		<?= $this->Paginator->next('<i class="fa-solid fa-angle-right"></i>', ['escape' => false]) ?>
		<?= $this->Paginator->last('<i class="fa-solid fa-angles-right"></i>', ['escape' => false]) ?>
		</div>
	</div>
	<p class="w3-text-gray"><?= $this->Paginator->counter('Página {{page}} de {{pages}}. Mostrando {{current}} resultados de un total de {{count}}') ?></p>

</div>

<?= $this->Html->link('<i class="fa-solid fa-plus"></i>', ['action' => 'add'], ['class' => 'w3-button w3-circle w3-xxlarge w3-golden w3-hover-dark-golden add', 'escape' => false]) ?>

<style>
	ul li{min-height:180px;margin:0;} .w3-display-left i.fa-solid{font-size:72px;padding-top:32px;float:left;} li p{padding:32px 0 12px 72px;}
	.w3-badge{width:24px;height:24px;} .w3-display-bottommiddle i{font-size:24px;padding:12px;}
	.w3-display-container div{padding:0 12px;}
	.w3-display-left{margin:4px 0;}
	.w3-display-topleft{padding:0;}
	li:nth-child(odd) {background: #efefef;} li:nth-child(even) {  background: #fff;}
	li:nth-child(odd) .id {color:#fff;} li:nth-child(even) .id {color:#ddd;}
</style>