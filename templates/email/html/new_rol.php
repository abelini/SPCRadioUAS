<?php $outterTR = 1; $innerTR = 1;?>

<div style="padding:0.01em 16px;color:#000!important;background-color:#efefef !important;">
	<?= $this->Html->image($this->Url->image('logo.png', ['fullBase' => true]), ['style' => 'display:block;float:right;max-width:96px;'])?>
	<h2>Compañeros locutores</h2>
	<p>Ya está disponible el <strong>rol de cabina</strong> para la semana del:</p>
</div>

<div style="padding:0.01em 16px;color:#fff!important;background-color:#2A4B7C!important;">
	<h3><?= $rol->fechaInicio->i18nFormat("d 'de' MMMM")?> al <?= $rol->fechaFin->i18nFormat("d 'de' MMMM 'de' YYYY")?></h3>
</div>

<div style="margin-top:16px!important;margin-bottom:16px!important;">

	<p>Encontrarán adjunto el archivo PDF con el rol de la semana.</p>
	
	<table style="border-collapse:collapse;border-spacing:0;width:100%;display:table;border:1px solid #ccc;" >

	<?php foreach($asignaciones as $dia => $asignaciones) : ?>
		<tr style="background:#<?= ($outterTR++ % 2 == 0)? 'eee' : 'fff'; ?>">
			<td style="width:auto;min-width:104px;max-width:216px;letter-spacing:2px;text-transform:uppercase;position:relative;padding:12px;text-align:center;">
				<span style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);-ms-transform:translate(-50%,-50%)">
					<?= $rol->fechaInicio->addDays($dia - 1)->i18nFormat("EEEE")?><br>
					<?= $rol->fechaInicio->addDays($dia - 1)->format('j')?>
				</span>
			</td>
			<td style="padding:0 !important;">
				<table style="border-collapse:collapse;border-spacing:0;width:100%;display:table;margin:0;border:1px solid #ccc;">
					<tr style="background:#fff">
						<th style="padding:8px;width:50%">Operador</th>
						<th style="padding:8px;width:50%">Turno</th>
					</tr>
					<?php foreach($asignaciones as $asignacion) : ?>
					<tr style="background:#<?= ($innerTR++ % 2 == 0)? 'fff' : 'eee'; ?>">
						<td style="padding:8px;"><?= $asignacion->locutor->name ?></td>
						<td style="padding:8px;"><?= $asignacion->horario->horaInicio ?> &#10230; <?= $asignacion->horario->horaFin ?></td>
					</tr>
					<?php endforeach; ?>
				</table>
			</td>
		<?php $innerTR = 1; ?>
		</tr>
	<?php endforeach;?>
	</table>
</div>	
	
<div style="padding:4px;width:100%;background-color:#c49e0d;color:#fff;">
	<p style="text-align:center">A T E N T A M E N T E</p>
	<p style="text-align:center">Lic. Marisol Herrera Guerrero</p>
</div>

<div style="padding:4px;width:100%;background-color:#877514;color:#fff;">
	<p style="text-align:center">Dirección de Radio Universidad Autónoma de Sinaloa © <?= $rol->fechaInicio->format("Y")?></p>
</div>





	
	
	
<style>
.w3-table,.w3-table-all{border-collapse:collapse;border-spacing:0;width:100%;display:table}.w3-table-all{border:1px solid #ccc}
.w3-bordered tr,.w3-table-all tr{border-bottom:1px solid #ddd}.w3-striped tbody tr:nth-child(even){background-color:#f1f1f1}
.w3-table-all tr:nth-child(odd){background-color:#fff}.w3-table-all tr:nth-child(even){background-color:#f1f1f1}
.w3-hoverable tbody tr:hover,.w3-ul.w3-hoverable li:hover{background-color:#ccc}.w3-centered tr th,.w3-centered tr td{text-align:center}
.w3-table td,.w3-table th,.w3-table-all td,.w3-table-all th{padding:8px 8px;display:table-cell;text-align:left;vertical-align:top}
.w3-table th:first-child,.w3-table td:first-child,.w3-table-all th:first-child,.w3-table-all td:first-child{padding-left:16px}

.w3-golden{background:#c49e0d !important;color:#fff !important;}
</style>