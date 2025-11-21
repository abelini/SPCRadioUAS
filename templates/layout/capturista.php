<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?= $AppName ?>
    </title>
    	<?= $this->Html->meta('favicon.png', 'https://radio.uas.edu.mx/wp-content/uploads/2020/06/cropped-RADIOUAS-LOGO-IOS-32x32.png', ['type' => 'icon']) ?>

    <?= $this->Html->css(['normalize.min', 'milligram.min', 'cake',]) ?>
    
	<?= $this->Html->script('jquery-3.7.1')?>
	
    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">
	<?= $this->Html->css(['custom']) ?>
	<style>
		.footer{clear:both;}
	</style>
</head>
<body>
	<header class="w3-deep-blue w3-top">
		<a href="#" class="w3-button w3-right w3-padding-small w3-hide-large" onclick="w3_open()"><i class="fa-solid fa-bars"></i></a>
		<?= $this->Html->image('radio-levels-wh.png', ['style' => 'width:98px;', 'class' => 'w3-left'])?>
		<h4 class="title"><?= $this->Html->link($AppName, ['controller' => 'dashboard']) ?></h4>	
	</header>
	
	<main class="main">
		<nav class="w3-sidebar w3-bar-block" style="width:220px">
			<?= $this->Html->link('<i class="fa-solid fa-microphone-lines"></i> Roles de Cabina', ['controller' => 'roles',], ['class' => 'w3-bar-item w3-button w3-border-bottom', 'escape' => false])?>
			<?= $this->Html->link('<i class="fa-regular fa-folder-open"></i> Solicitudes', ['controller' => 'solicitudes',], ['class' => 'w3-bar-item w3-button w3-border-bottom', 'escape' => false])?>
			<?= $this->Html->link('<i class="fa-regular fa-clock"></i> Horas extras', ['controller' => 'locutores', 'action' => 'horas_extras'], ['class' => 'w3-bar-item w3-button w3-border-bottom', 'escape' => false])?>
			
	
			<?= $this->Html->link('<i class="fa-solid fa-right-from-bracket"></i> Salir', ['controller' => 'usuarios', 'action' => 'logout'], ['class' => 'w3-bar-item w3-red w3-button', 'escape' => false])?>
		</nav>
		<div class="content-box" style="">
			<div class="w3-container">
				<?= $this->Flash->render() ?>
				<?= $this->fetch('content') ?>
			</div>
		</div>
		<div class="c"></div>
	</main>
	
    <footer class="w3-padding-large w3-bottom">
		<p class="w3-center">Dirección de Radio Universidad Autónoma de Sinaloa &copy; <?= $datetime->format('Y')?></p>
    </footer>
    <script src="https://kit.fontawesome.com/18176e4df9.js" crossorigin="anonymous"></script>
</body>
</html>
