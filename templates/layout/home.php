<!DOCTYPE html>
<html>

<head>
	<?= $this->Html->charset() ?>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="robots" content="noindex, nofollow">
	<title><?= $AppName ?></title>
	<?= $this->Html->meta('favicon.png', 'https://radio.uas.edu.mx/wp-content/uploads/2020/06/cropped-RADIOUAS-LOGO-IOS-32x32.png', ['type' => 'icon']) ?>
	<?= $this->Html->css(['normalize.min', 'milligram.min', 'cake',]) ?>
	<?= $this->fetch('meta') ?>
	<?= $this->fetch('css') ?>
	<?= $this->fetch('script') ?>
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<?= $this->Html->css(['custom']) ?>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
	<style>
		:root {
			--c-bg: #24292f;
			--c-card: #ffffff;
			--c-border: #d0d7de;
			--c-text: #1f2328;
			--c-muted: #656d76;
			--c-accent: #0969da;
			--c-accent-hover: #0550ae;
		}

		* {
			box-sizing: border-box;
		}

		html,
		body {
			height: 100%;
			font-family: 'Inter', sans-serif;
		}

		body.login-bg {
			background: linear-gradient(135deg, #1a2b4c 0%, #2d4a6c 50%, #3d5a7c 100%);
		}

		.login-wrapper {
			display: flex;
			align-items: center;
			justify-content: center;
			min-height: 100vh;
			padding: 24px;
		}

		.login-card {
			background: var(--c-card);
			border-radius: 12px;
			box-shadow: 0 8px 32px rgba(0, 0, 0, 0.25);
			width: 100%;
			max-width: 1100px;
			display: grid;
			grid-template-columns: 1fr 1.5fr;
			overflow: hidden;
		}

		.login-left {
			background: linear-gradient(160deg, #d4e4f1ff 0%, #fff 40%, #d4e4f1ff 100%);
			padding: 56px;
			display: flex;
			flex-direction: column;
			align-items: center;
			justify-content: center;
			text-align: center;
			position: relative;
			overflow: hidden;
		}

		.login-left::before {
			content: '';
			position: absolute;
			top: -50%;
			left: -50%;
			width: 200%;
			height: 200%;
			background: radial-gradient(circle, rgba(9, 105, 218, 0.08) 0%, transparent 50%);
		}

		.login-left img {
			width: 280px;
			margin-bottom: 32px;
			position: relative;
			z-index: 1;
		}

		.login-left h2 {
			font-size: 32px;
			font-weight: 600;
			margin: 0 0 12px;
			color: #1f2328;
		}

		.login-left p {
			font-size: 18px;
			opacity: 0.75;
			margin: 0;
			color: #656d76;
		}

		.login-right {
			padding: 56px 48px;
			display: flex;
			flex-direction: column;
			justify-content: center;
		}

		.login-right img.logo {
			width: 80px;
			margin-bottom: 12px;
		}

		.login-right h2 {
			font-size: 28px;
			color: var(--c-text);
			margin: 0 0 8px;
		}

		.login-right .subtitle {
			font-size: 15px;
			color: var(--c-muted);
			margin: 0 0 40px;
		}

		.login-right .input-field {
			width: 100%;
			padding: 14px 16px;
			font-size: 16px;
			border: 1px solid var(--c-border);
			border-radius: 6px;
			margin-bottom: 20px;
			background: #fff;
		}

		.login-right .input-field:focus {
			outline: none;
			border-color: var(--c-accent);
			box-shadow: 0 0 0 3px rgba(9, 105, 218, 0.15);
		}

		.login-right label {
			display: block;
			font-size: 14px;
			font-weight: 500;
			color: var(--c-text);
			margin-bottom: 6px;
		}

		.login-right .btn-submit {
			width: 100%;
			padding: 12px;
			font-size: 15px;
			font-weight: 500;
			color: #fff;
			background: var(--c-accent);
			border: none;
			border-radius: 6px;
			cursor: pointer;
			margin-top: 8px;
		}

		.login-right .btn-submit:hover {
			background: var(--c-accent-hover);
		}

		.login-right .options {
			display: flex;
			justify-content: space-between;
			align-items: center;
			margin-bottom: 20px;
			font-size: 14px;
			color: var(--c-muted);
		}

		.login-right .options a {
			color: var(--c-accent);
			text-decoration: none;
		}

		.login-right .options a:hover {
			text-decoration: underline;
		}

		.login-right .footer {
			margin-top: 24px;
			text-align: center;
			font-size: 12px;
			color: var(--c-muted);
		}

		@media (max-width: 768px) {
			.login-card {
				grid-template-columns: 1fr;
			}

			.login-left {
				display: none;
			}

			.login-right {
				padding: 32px 24px;
			}
		}

		h1,
		h2,
		h3 {
			text-transform: none;
		}
	</style>
</head>

<body class="login-bg">
	<div class="login-wrapper">
		<div class="login-card">
			<div class="login-left">
				<?= $this->Html->image($AppLogo, ['alt' => 'Radio Universidad', 'style' => 'width:280px']) ?>
			</div>
			<div class="login-right">
				<h2><?= $AppName ?></h2>
				<p class="subtitle">Dirección de Radio UAS</p>

				<?= $this->Flash->render() ?>

				<?= $this->fetch('content') ?>

				<div class="footer">
					<p>&copy; <?= date('Y') ?> Radio Universidad Autónoma de Sinaloa</p>
				</div>
			</div>
		</div>
	</div>

	<script src="https://kit.fontawesome.com/1451f5151b.js" crossorigin="anonymous"></script>
</body>

</html>