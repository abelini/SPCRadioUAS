<div class="content">
	<div class="w3-deep-blue w3-padding">
		<h5><i class="fa-regular fa-clock"></i> Horas extras del personal para la quincena</h5>
	</div>
	<div class="w3-low-blue w3-padding w3-center">
		<h6 style="text-transform:uppercase"><?= $empieza->i18nFormat("d 'de' MMMM")?> <i class="fa-solid fa-arrow-right-long"></i> <?= $termina->i18nFormat("d 'de' MMMM")?></h6>
	</div>
	
	<p class="w3-section"><strong>HORAS EXTRAS POR DÍAS INHÁBILES</strong>:</p>
	<p>
		<ul class="w3-ul">
			<?php foreach($feriadosDeLaQuincena as $dia) : ?>
			<li><i class="fa-regular fa-calendar-xmark"></i> <?= $dia->i18nFormat("eeee d 'de' MMMM") ?></li>
			<?php endforeach; ?>
		</ul>
	</p>
	
	<table class="w3-table-all w3-section">
		<tr>
			<th class="No">Empleado</th>
			<th class="Name">Nombre</th>
			<th class="Hours">Horas extras</th>
		</tr>
		<?php if(count($horasXCabina) == 0) : ?>
		<tr>
			<td colspan="3" class="w3-center">No hay días inhábiles en este período</td>
		</tr>
		<?php endif; ?>
		<?php foreach($horasXCabina as $locutor) : ?>
		<tr>
			<td><?= $locutor['locutor']->empleado ?></td>
			<td><?= $locutor['locutor']->fullname ?></td>
			<td><?= $locutor['horas'] ?></td>
		</tr>
		<?php endforeach; ?>
	</table>
	
	<hr/>
	
	<p class="w3-section"><strong>HORAS EXTRAS POR EVENTOS CUBIERTOS (Maestros de ceremonia)</strong>:</p>
	
	<table class="w3-table-all w3-section">
		<tr>
			<th class="No">Empleado</th>
			<th class="Name">Nombre</th>
			<th class="Hours">Horas extras</th>
		</tr>
		
		<?php foreach($horasXEvento as $locutor) : ?>
		<tr>
			<td><?= $locutor['locutor']->empleado ?></td>
			<td>
				<?= $locutor['locutor']->fullname ?>
				
			</td>
			<td><?= $locutor['horas'] ?></td>
		</tr>
		<tr>
			<td class="picture">
				<?= $this->Html->image($locutor['locutor']->photo, ['class' => 'w3-image w3-border'])?>
			</td>
			<td>
				<ul class="w3-ul">
					<?php foreach($locutor['eventos'] as $evento) : ?>
					<li><i class="fa-solid fa-user-tie"></i> <?= $evento->shortDesc() ?></li>
					<li><i class="fa-regular fa-calendar-check"></i> <?= $evento->fecha->i18nFormat(\IntlDateFormatter::LONG) ?></li>
					<?php endforeach; ?>
				</ul>
			</td>
			<td></td>
		</tr>
		<?php endforeach; ?>
	</table>
	
<style>
	.w3-text-gray{color:#ddd;} td:first-child, td:nth-child(3) {text-align:center;}
	.No{width:10%} .Name{width:80%} .Hours{width:10%}
	td.picture {vertical-align:middle !important;} img{width:80px;padding:4px;}
	
</style>