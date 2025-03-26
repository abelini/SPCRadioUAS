<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $this->fetch('title') ?></title>
    	<?= $this->Html->meta('favicon.png', 'https://radio.uas.edu.mx/wp-content/uploads/2020/06/cropped-RADIOUAS-LOGO-IOS-32x32.png', ['type' => 'icon']) ?>

    <?= $this->Html->css(['normalize.min', /*'milligram.min',*/ 'fonts', 'cake']) ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    	<style stype="text/css">
		@import url('https://fonts.googleapis.com/css2?family=Khand:wght@300;400&display=swap');
	</style>
</head>
<body>
	<nav class="top-nav">
		<div class="top-nav-title">
			<?= $this->Html->image('logo.png', ['class' => 'logo'])?>
        </div>
		<div class="top-nav-links">

		</div>
	</nav>
	<main class="main">
        <div class="w3-container">
			<?= $this->fetch('content') ?>
        </div>
	</main>
	<footer>
	</footer>
	<script src="https://kit.fontawesome.com/18176e4df9.js" crossorigin="anonymous"></script>
	<style>
		.w3-galaxy-blue{color:#fff!important;background-color:#2A4B7C!important;}
		h1{font-family:"Khand";font-weight:400;font-style: normal;color:#2A4B7C;font-size:32px;line-height:32px;font-weight:500;}
		.top-nav {padding:1rem;display:inherit;} .logo{margin:auto;max-width:15%;min-width:10%;display:block;}
		.main {max-width:1200px;margin:0 auto;} footer {padding:32px;}
		@media only screen and (max-width: 600px) {
			.w3-container {padding:0;}
			.top-nav {display:none;}
		}
	</style>
</body>
</html>
