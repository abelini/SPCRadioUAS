<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?= $AppName ?>
    </title>
    	<?= $this->Html->meta('favicon.png', 'https://radio.uas.edu.mx/wp-content/uploads/2020/06/cropped-RADIOUAS-LOGO-IOS-32x32.png', ['type' => 'icon']) ?>

    <?= $this->Html->css(['normalize.min', 'milligram.min',  'cake']) ?>
    
	<?= $this->Html->script('jquery-3.7.1')?>
	
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
	<?= $this->Html->css(['custom']) ?>
	<style>
		.footer{clear:both;}
	</style>
	<style stype="text/css">
		@import url('https://fonts.googleapis.com/css2?family=Khand:wght@300;400&display=swap');
	</style>
</head>
<body>
	<header class="main-header">
		<?= $this->Html->link($AppName, ['controller' => 'dashboard'], ['class' => 'header-link']) ?>
	</header>
	
	<main class="main-content">
		<nav class="sidebar">
			<div class="sidebar-nav">
				<?= $this->Html->link('<i class="fa-solid fa-microphone-lines"></i> Roles de Cabina', ['controller' => 'roles'], ['class' => 'sidebar-link', 'escape' => false])?>
				<?= $this->Html->link('<i class="fa-regular fa-folder-open"></i> Solicitudes', ['controller' => 'solicitudes'], ['class' => 'sidebar-link', 'escape' => false])?>
				<?= $this->Html->link('<i class="fa-regular fa-clock"></i> Horas extras', ['controller' => 'locutores', 'action' => 'horas_extras'], ['class' => 'sidebar-link', 'escape' => false])?>
				<?= $this->Html->link('<i class="fa-solid fa-radio"></i> Programas', ['controller' => 'programas'], ['class' => 'sidebar-link', 'escape' => false])?>
				<?= $this->Html->link('<i class="fa-solid fa-file-contract"></i> Bitácora de cabina', ['controller' => 'bitacora_cabina'], ['class' => 'sidebar-link', 'escape' => false])?>
				<?= $this->Html->link('<i class="fa-solid fa-file-signature"></i> Bitácora de vigilancia', ['controller' => 'bitacora_vigilancia'], ['class' => 'sidebar-link', 'escape' => false])?>
				<?= $this->Html->link('<i class="fa-solid fa-chart-pie"></i> Reportes de cabina', ['controller' => 'reportes_cabinas', 'action' => 'reportes'], ['class' => 'sidebar-link', 'escape' => false])?>
				<?= $this->Html->link('<i class="fa-solid fa-chart-simple"></i> Reportes de vigilancia', ['controller' => 'reportes_vigilancia', 'action' => 'reportes'], ['class' => 'sidebar-link', 'escape' => false])?>
				<?//= $this->Html->link('<i class="fa-solid fa-users"></i> Usuarios', ['controller' => 'usuarios'], ['class' => 'sidebar-link', 'escape' => false])?>
				<?= $this->Html->link('<i class="fa-solid fa-right-from-bracket"></i> Salir', ['controller' => 'usuarios', 'action' => 'logout'], ['class' => 'sidebar-link sidebar-link-danger', 'escape' => false])?>
			</div>
		</nav>
		<div class="content-box">
			<?= $this->Flash->render() ?>
			<?= $this->fetch('content') ?>
		</div>
	</main>
	
    <footer class="main-footer">
		<p class="footer-text">Dirección de Radio Universidad Autónoma de Sinaloa &copy; <?= date('Y') ?></p>
    </footer>
    <script src="https://kit.fontawesome.com/18176e4df9.js" crossorigin="anonymous"></script>
</body>
</html>
