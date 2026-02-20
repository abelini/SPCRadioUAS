<!DOCTYPE html>
<html>

<head>
	<?= $this->Html->charset() ?>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= $this->fetch('title') ?></title>
	<?= $this->Html->meta('favicon.png', 'https://radio.uas.edu.mx/wp-content/uploads/2020/06/cropped-RADIOUAS-LOGO-IOS-32x32.png', ['type' => 'icon']) ?>
	<?= $this->Html->css(['normalize.min', /*'milligram.min',*/ 'fonts', 'cake']) ?>
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/5/w3.css">
	<?= $this->Html->css(['custom']) ?>
	<?= $this->fetch('meta') ?>
	<?= $this->fetch('css') ?>
	<?= $this->fetch('script') ?>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Doto:wght@600&display=swap" rel="stylesheet">
	<style>

	</style>
</head>

<body>
	<nav class="top-nav">
		<div class="top-nav-title">
			<?= $this->Html->image('LogoRolCabinaPDF.png', ['class' => 'logo']) ?>
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
		<p class="w3-center">Dirección de Radio Universidad Autónoma de Sinaloa &copy; 2025</p>
	</footer>
	<script src="https://kit.fontawesome.com/18176e4df9.js" crossorigin="anonymous"></script>
	<style>
		.w3-galaxy-blue {
			color: #0094CD !important;
			background-color: #1a2b4c !important;
		}

		body {
			background: #dbe1ea !important;
		}

		h2 {
			font-size: 20px;
			text-transform: uppercase;
		}

		.w3-low-blue {
			padding: 1px;
		}

		h1 {
			font-family: "Montserrat";
			font-weight: 600;
			font-style: normal;
			color: #0094cd;
			font-size: 26px;
			line-height: 32px;
			font-weight: 500;
			text-transform: uppercase;
		}

		.top-nav {
			padding: 1rem;
			display: inherit;
		}

		.logo {
			margin: auto;
			max-width: 100%;
			min-width: 50%;
			display: block;
		}

		.main {
			max-width: 1200px;
			margin: 0 auto;
		}

		footer {
			padding: 32px;
			background: none;
		}

		@media only screen and (max-width: 600px) {
			.w3-container {
				padding: 0;
			}

			.top-nav {
				display: none;
			}
		}
	</style>
</body>

</html>