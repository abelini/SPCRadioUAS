<div class="content">
	<h3 class="t w3-text-gray">BIENVENIDA</h3>
	<h1 class="t w3-text-gray"><?= $user->name ?></h1>
	
	<hr>
	
	<div class="dashboard w3-container w3-section w3-row-padding">
		<div class="w3-col l3">
			<h4 class="w3-margin-bottom"><i class="fa-solid fa-bell"></i> <strong>NOTIFICACIONES</strong></h4>
			
			<div class="w3-section message success">
				<h5>Sin novedad</h5>
				<p>Todo marcha a la perfección.</p>
			</div>  
		</div>
		
		
		<div class="w3-col l9">
			<h4 class="w3-margin-bottom"><i class="fa-solid fa-chart-simple"></i> <strong>ESTADÍSTICAS</strong></h4>
			
			<p class="w3-padding-16">Hay <strong><?= $solicitudes['Total']?> solicitudes</strong> registradas en el sistema.</p>
			
			<div class="w3-row">
				<div class="w3-col l3">
					<div class="w3-section w3-leftbar w3-border-purple">
						<div class="w3-container w3-padding">Grabaciones de spot</div>
					</div>
					
					<div class="w3-section w3-leftbar w3-border-green">
						<div class="w3-container w3-padding">Maestros de ceremonia</div>
					</div>
					
					<div class="w3-section w3-leftbar w3-border-orange">
						<div class="w3-container w3-padding">Controles remotos</div>
					</div>
				</div>
				<div class="w3-col l9">
					<div class="w3-light-grey w3-section">
						<div class="w3-container w3-padding w3-purple" style="width:<?= ($solicitudes['TotalGDS']/$solicitudes['Total'] * 100) ?>%"><?= $this->Number->format($solicitudes['TotalGDS'])?></div>
					</div>
					
					<div class="w3-light-grey w3-section">
						<div class="w3-container w3-padding w3-green" style="width:<?= ($solicitudes['TotalMDC']/$solicitudes['Total'] * 100) ?>%"><?= $this->Number->format($solicitudes['TotalMDC'])?></div>
					</div>
					
					<div class="w3-light-grey w3-section">
						<div class="w3-container w3-padding w3-orange" style="width:<?= ($solicitudes['TotalCR']/$solicitudes['Total'] * 100) ?>%"><?= $this->Number->format($solicitudes['TotalCR'])?></div>
					</div>
				</div>
			</div>
  
			<hr>
			
			<p class="w3-padding-16">Hay <strong><?= $bitacoras['Total']?> registros diarios</strong> en la Bitácora de Cabina. Los registros van desde el <strong><?= $bitacoras['FirstOne']->i18nFormat(\IntlDateFormatter::LONG) ?></strong> hasta el <strong><?= $bitacoras['LastOne']->i18nFormat(\IntlDateFormatter::LONG)?></strong>. Abarcando un período de <strong><?= $bitacorasDiff ?></strong>.</p>
			
			<p>En estos registros se detalla el cumplimiento de los <strong><?= $programas['Total']?> programas</strong> que hay al aire.</p>

		</div>
	</div>

	<div class="w3-padding-large">
		<p class="w3-right w3-text-gray"><?= $datetime->i18nFormat(\IntlDateFormatter::FULL) ?></p>
	</div>
</div>

<style>
	.t{letter-spacing:2px;color:#ccc !important;} p{margin:0;}
	.dashboard{background:url(<?= $this->Url->image('SPC-bg-home.webp')?>) no-repeat;min-height:700px;background-size:contain;background-position:center;}
}
</style>