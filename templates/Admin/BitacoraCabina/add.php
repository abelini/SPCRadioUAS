<div class="bitacoraCabina form content">
	<?= $this->Form->create($bitacora) ?>

			<h4>Agregar una bitácora faltante</h4>
			
			<?= $this->Form->control('fecha')?>

		<?= $this->Form->button(__('Submit')) ?>
	<?= $this->Form->end() ?>
</div>
