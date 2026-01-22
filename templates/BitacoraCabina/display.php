<?= $this->Flash->render() ?>

<div class="w3-">
	<div class="w3-galaxy-blue w3-padding w3-center">
		<span
			class="w3-left w3-xxlarge"><?= $bitacora->previous() != null ? $this->Html->link('<i class="fa-solid fa-circle-chevron-left"></i>', ['?' => ['d' => $bitacora->previous()->fecha->format('Y-m-d')]], ['escape' => false]) : '' ?></span>
		<span
			class="w3-right w3-xxlarge"><?= $bitacora->next() != null ? $this->Html->link('<i class="fa-solid fa-circle-chevron-right"></i>', ['?' => ['d' => $bitacora->next()->fecha->format('Y-m-d')]], ['escape' => false]) : '' ?></span>
		<h1><?= $bitacora ?></h1>

	</div>

	<div class="w3-row w3-low-blue w3-padding">
		<div class="w3-col l2 w3-bold">Operador</div>
		<div class="w3-col l2 w3-bold">Turno</div>
		<div class="w3-col l3 w3-bold">Reporte de programas</div>
		<div class="w3-col l1 w3-bold">Enlaces</div>
		<div class="w3-col l4 w3-bold">Reporte de enlaces remotos</div>
	</div>

	<?= $this->Form->create($bitacora, ['url' => ['action' => 'update'], 'type' => 'PUT']) ?>

	<?php for ($i = 0; $i < count($asignaciones); $i++): ?>
		<?php $disableControl = $checkTimeToDisable($asignaciones[$i]->horario, $bitacora->reportes[$i]->ID ?? 0); ?>

		<div
			class="w3-row-padding w3-padding <?= $asignaciones[$i]->classForCurrent($bitacora->fecha, 'w3-card-4 active'); ?>">
			<div class="w3-col l2">
				<p class="w3-bold"><?= $asignaciones[$i]->locutor->name ?></p>
				<?= $this->Html->image($asignaciones[$i]->locutor->photo, ['class' => 'w3-image profile']) ?>
			</div>
			<div class="w3-col l2">
				<p><?= $asignaciones[$i]->horario ?></p>
				<p class="created-mod">
					<?= isset($bitacora->reportes[$i]) ? $bitacora->reportes[$i]->created . '<br/>' . $bitacora->reportes[$i]->modified : '' ?><br />
				</p>
			</div>

			<div class="w3-col l3">
				<?php $programCounter = 0; ?>
				<?php foreach ($asignaciones[$i]->dia->programas as $id => $programa): ?>
					<fieldset>
						<legend><?= $programa ?></legend>
						<?= $this->Form->radio('reportes.' . $i . '.reportes_programas.' . $programCounter . '.status', $programStatuses, ['class' => 'w3-radio', 'disabled' => $disableControl]) ?>
						<?= $this->Form->hidden('reportes.' . $i . '.reportes_programas.' . $programCounter . '.programaID', ['value' => $programa->ID]) ?>
						<?= $this->Form->hidden('reportes.' . $i . '.reportes_programas.' . $programCounter . '.ID') ?>
					</fieldset>
					<?php $programCounter++; ?>
				<?php endforeach; ?>
				<?php $programCounter = 0; ?>
				&nbsp;
			</div>

			<div class="w3-col l1">
				<?= $this->Form->control('reportes.' . $i . '.controles', ['label' => false, 'class' => 'w3-input', 'disabled' => $disableControl]) ?>
				<p class="created-mod">
					RC#<?= isset($bitacora->reportes[$i]) ? $bitacora->reportes[$i]->ID : '' ?>
				</p>
			</div>

			<div class="w3-col l4">
				<?= $this->Form->control('reportes.' . $i . '.reporte', ['label' => false, 'class' => 'w3-input', 'placeholder' => 'Sin novedad', 'disabled' => $disableControl]) ?>
			</div>
			<?= $this->Form->hidden('reportes.' . $i . '.ID') ?>
			<?= $this->Form->hidden('reportes.' . $i . '.bitacoraID', ['value' => $bitacora->ID]) ?>
			<?= $this->Form->hidden('reportes.' . $i . '.locutorID', ['value' => $asignaciones[$i]->locutorID]) ?>
			<?= $this->Form->hidden('reportes.' . $i . '.horaInicio', ['value' => $asignaciones[$i]->horario->getTimeAsString('horaInicio')]) ?>
			<?= $this->Form->hidden('reportes.' . $i . '.horaFin', ['value' => $asignaciones[$i]->horario->getTimeAsString('horaFin')]) ?>
		</div>
	<?php endfor; ?>


	<?= $this->Form->hidden('ID') ?>
	<?php //= $this->Form->hidden('fecha', ['value' => $bitacora->fecha->toIso8601String()]) ?>

	<div class="w3-row w3-padding w3-low-blue w3-center">
		Valores: <span style="font-weight:normal">(V) Programa en vivo, (G) Programa grabado, (S) Programa suspendido
			por la Dirección, (X) El conductor no se presentó</span>
	</div>
	<div class="w3-padding w3-galaxy-blue w3-center">
		En caso de haber, registrar un enlace remoto por línea. Si no, favor de dejar en blanco el espacio.
	</div>

	<div class="w3-center">
		<?= $this->Form->button('<i class="fa-solid fa-paper-plane"></i> ACTUALIZAR', ['type' => 'submit', 'disabled' => $disabledSubmit, 'class' => 'w3-button w3-padding-large w3-section w3-center w3-round w3-galaxy-blue w3-large', 'escapeTitle' => false]) ?>
	</div>
	<?= $this->Form->end(); ?>

</div>

<div class="w3-container w3-white w3-padding"
	style="position: fixed; bottom: 40px; right: 20px; z-index: 100;width:340px;">
	<h6><i class="fa-brands fa-facebook" style="color:#1877F2"></i> Generación de publicación para redes sociales</h6>
	<button class="w3-button w3- w3-blue w3-card-4 w3-large" style=" margin-right: 5px;"
		onclick="abrirModal('live_show')" title="Generar publicación para Programa">
		<b>Programas</b>
	</button>

	<button class="w3-button w3- w3-green w3-card-4 w3-large" style="" onclick="abrirModal('live_broadcast')"
		title="Generar publicación para Controles Remotos">
		<b>Controles Remotos</b>
	</button>
</div>

<div id="miSidebar" class="w3-sidebar w3-card w3-animate-right"
	style="display:none; right:0; top:0; width:40%; height:100%; z-index:999 !important;">

	<button onclick="cerrarModal()" class="w3-button w3-large w3-display-topright w3-galaxy-blue w3-hover-red">
		<i class="fa-solid fa-xmark"></i>
	</button>

	<div class="w3-container w3-galaxy-blue">
		<h4 class="w3-text-light-blue">Generación de Publicación para Facebook</h4>
	</div>

	<div id="contenido-ajax" class="w3-container w3-padding-16">
	</div>
</div>

<div id="miOverlay" class="w3-overlay" style="z-index:998;"></div>

<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

<script>
	function abrirModal(tipoContenido) {
		// 1. Mostrar sidebar y overlay
		document.getElementById("miSidebar").style.display = "block";
		document.getElementById("miOverlay").style.display = "block";

		// 2. Referencia al contenedor y mostrar "Cargando"
		const contenedor = document.getElementById("contenido-ajax");
		contenedor.innerHTML = '<div class="w3-center w3-padding-32"><i class="fa fa-spinner w3-spin w3-xxlarge"></i><p>Cargando...</p></div>';

		// 3. Petición AJAX
		const url = `<?= $this->Url->build(['controller' => 'Cabina', 'action' => 'social', 'prefix' => 'Api']) ?>?type=${tipoContenido}`;

		fetch(url)
			.then(response => {
				if (!response.ok) throw new Error("Error red");
				return response.text();
			})
			.then(html => {
				contenedor.innerHTML = html;
			})
			.catch(error => {
				console.error(error);
				contenedor.innerHTML = '<div class="w3-panel w3-red"><p>Error al cargar contenido.</p></div>';
			});
	}

	function cerrarModal() {
		document.getElementById("miSidebar").style.display = "none";
		document.getElementById("miOverlay").style.display = "none";
	}
</script>
<script>
	document.addEventListener('change', function (e) {
		if (e.target && e.target.id === 'select-programa') {
			const select = e.target;
			const inputConduccion = document.getElementById('input-conduccion');
			const inputInvitados = document.getElementById('input-invitados');
			const inputTema = document.getElementById('input-tema');
			const programaSeleccionado = select.value;
			const urlBase = "<?= $this->Url->build(['controller' => 'Cabina', 'action' => 'getProgramInfo', 'prefix' => 'Api']) ?>";

			if (!programaSeleccionado) {
				return;
			}

			fetch(`${urlBase}?name=${encodeURIComponent(programaSeleccionado)}`)
				.then(response => {
					if (!response.ok) throw new Error('Error en la red');
					return response.json();
				})
				.then(data => {
					inputConduccion.value = data.programa.conduccion || '';
					if (data.programa.tema != null) {
						inputTema.value = data.programa.tema.tema || '';
						inputInvitados.value = data.programa.tema.invitados || '';
					} else {
						inputTema.value = '';
					}
				})
				.catch(error => {
					console.error('Error:', error);
					//inputParticipantes.value = ''; // Limpiar si hay error
				})
				.finally(() => {
					//inputParticipantes.style.opacity = '1'; // Restaurar opacidad
				});
		}
	});
</script>
<script>
	function generateSocialContent(event, form) {
		event.preventDefault();

		const btn = event.submitter || form.querySelector('button[type="submit"]');
		const textoOriginal = btn.innerHTML;

		btn.disabled = true;
		btn.innerHTML = '<i class="fa fa-circle-o-notch w3-spin"></i> Generando respuesta...';
		const contenedor = document.getElementById("ai-generated-social-content");
		contenedor.innerHTML = `
			<div class="w3-panel w3-animate-opacity">
				<p class="w3-text-gray">Gemini está pensando...</p>
				<div class="w3-round-xlarge">
					<div class="w3-container w3-center">
						<i class="fa-solid fa-spinner w3-spin w3-text-gray" style="font-size:64px"></i>
					</div>
				</div>
			</div>`;
		const url = form.action;
		const datos = new FormData(form);

		fetch(url, {
			method: 'POST',
			body: datos,
			headers: {
				'X-Requested-With': 'XMLHttpRequest'
			}
		})
			.then(response => {
				if (!response.ok) throw new Error("Error de red");
				return response.text();
			})
			.then(markdownTexto => {
				const html = marked.parse(markdownTexto);
				contenedor.innerHTML = html;
				btn.disabled = false;
				btn.innerHTML = textoOriginal;
			})
			.catch(error => {
				console.error('Error:', error);
				contenedor.innerHTML = '<p>Límite de peticiones excedido. Intenta de nuevo en 1 minuto.</p>';
				btn.disabled = false;
				btn.innerHTML = textoOriginal;
			});

		return false;
	}
</script>

<style>
	@media screen and (max-width: 600px) {
		#miSidebar {
			width: 100% !important;
			/* Fuerza el ancho total */
			min-width: 100% !important;
			right: 0 !important;
			top: 0 !important;
			height: 100% !important;
		}

		.ai-generated-social-content {
			padding: 0 16px !important;
		}
	}

	.w3-row-padding {
		background-color: #fafafa;
	}

	.uas-dorado {
		font-weight: bold;
		background: #c49e0d;
		color: #fff;
	}

	.uas-amarillo {
		background: #877514;
		color: #fff;
	}

	.w3-row-padding.active {
		background-color: #eee;
		margin-bottom: 8px;
		position: relative;
		z-index: 10;
	}

	img.profile {
		width: 40%;
		display: block;
		margin: auto;
		filter: grayscale(95%);
		border: 2px #333 solid;
	}

	.active img.profile {
		filter: none;
		width: 60%;
	}

	fieldset label {
		padding-right: 12px;
	}

	body {
		background: #fff;
	}

	.w3-padding {
		padding16px !important;
	}

	.created-mod {
		color: #dbdbdb;
	}
</style>




<?php $this->assign('title', $bitacora); ?>