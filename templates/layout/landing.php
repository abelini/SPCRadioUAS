<!DOCTYPE html>
<html>
<head>
	<?= $this->Html->charset() ?>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="robots" content="noindex, nofollow">
	<title><?= $AppName ?></title>
	<?= $this->Html->meta('favicon.png', 'https://radio.uas.edu.mx/wp-content/uploads/2020/06/cropped-RADIOUAS-LOGO-IOS-32x32.png', ['type' => 'icon']) ?>
	<?= $this->Html->css(['normalize.min', 'milligram.min']) ?>
	<?= $this->Html->css(['custom']) ?>
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
	<?= $this->fetch('meta') ?>
	<?= $this->fetch('css') ?>
	<?= $this->fetch('script') ?>
	<style>
		:root {
			--color-bg: #24292f;
			--color-card: #ffffff;
			--color-border: #d0d7de;
			--color-text: #1f2328;
			--color-text-muted: #656d76;
			--color-accent: #0969da;
			--color-accent-hover: #0550ae;
			--radius-md: 8px;
			--radius-lg: 12px;
			--shadow-lg: 0 8px 24px rgba(31, 35, 40, 0.2);
		}

		* { box-sizing: border-box; }

		html, body {
			height: 100%;
			margin: 0;
			padding: 0;
			font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
		}

		body {
			background: var(--color-bg);
			background-image: url('<?= $this->Url->image('bg.webp')?>');
			background-size: cover;
			background-position: center;
		}

		.login-wrapper {
			display: flex;
			align-items: center;
			justify-content: center;
			min-height: 100vh;
			padding: 24px;
		}

		.login-card {
			background: var(--color-card);
			border-radius: var(--radius-lg);
			box-shadow: var(--shadow-lg);
			width: 100%;
			max-width: 900px;
			overflow: hidden;
			display: grid;
			grid-template-columns: 1fr 1fr;
		}

		.login-visual {
			background: linear-gradient(135deg, var(--color-accent) 0%, #8250df 100%);
			display: flex;
			align-items: center;
			justify-content: center;
			padding: 48px;
			position: relative;
		}

		.login-visual::before {
			content: '';
			position: absolute;
			inset: 0;
			background: 
				radial-gradient(circle at 20% 80%, rgba(255,255,255,0.15) 0%, transparent 50%),
				radial-gradient(circle at 80% 20%, rgba(255,255,255,0.1) 0%, transparent 40%);
		}

		.login-visual-content {
			position: relative;
			z-index: 1;
			text-align: center;
		}

		.login-visual img {
			width: 160px;
			height: auto;
			margin-bottom: 24px;
		}

		.login-visual h2 {
			color: #fff;
			font-size: 28px;
			font-weight: 600;
			margin: 0 0 8px;
		}

		.login-visual p {
			color: rgba(255,255,255,0.8);
			font-size: 16px;
			margin: 0;
		}

		.login-form {
			padding: 48px;
			display: flex;
			flex-direction: column;
			justify-content: center;
		}

		.login-logo img {
			width: 64px;
			height: auto;
			margin-bottom: 8px;
		}

		.login-logo h2 {
			color: var(--color-text);
			font-size: 24px;
			font-weight: 600;
			margin: 0 0 4px;
		}

		.login-logo .subtitle {
			color: var(--color-text-muted);
			font-size: 14px;
			margin: 0 0 32px;
		}

		.login-group {
			margin-bottom: 20px;
		}

		.login-group label {
			display: block;
			font-size: 14px;
			font-weight: 500;
			color: var(--color-text);
			margin-bottom: 8px;
		}

		.login-group input[type="text"],
		.login-group input[type="password"] {
			width: 100%;
			padding: 12px 14px;
			font-size: 15px;
			border: 1px solid var(--color-border);
			border-radius: var(--radius-md);
			background: #fff;
			color: var(--color-text);
			transition: all 0.2s ease;
		}

		.login-group input:focus {
			outline: none;
			border-color: var(--color-accent);
			box-shadow: 0 0 0 3px rgba(9, 105, 218, 0.15);
		}

		.login-group input::placeholder {
			color: #8c959f;
		}

		.login-options {
			display: flex;
			align-items: center;
			justify-content: space-between;
			margin-bottom: 24px;
		}

		.login-options label {
			display: flex;
			align-items: center;
			gap: 8px;
			font-size: 14px;
			color: var(--color-text-muted);
			cursor: pointer;
		}

		.login-options input[type="checkbox"] {
			width: 16px;
			height: 16px;
			accent-color: var(--color-accent);
		}

		.login-options a {
			font-size: 14px;
			color: var(--color-accent);
			text-decoration: none;
		}

		.login-options a:hover {
			text-decoration: underline;
		}

		.login-submit {
			width: 100%;
			padding: 12px 24px;
			font-size: 15px;
			font-weight: 500;
			color: #fff;
			background: var(--color-accent);
			border: none;
			border-radius: var(--radius-md);
			cursor: pointer;
			transition: all 0.2s ease;
		}

		.login-submit:hover {
			background: var(--color-accent-hover);
		}

		.login-footer {
			margin-top: 32px;
			text-align: center;
		}

		.login-footer p {
			font-size: 13px;
			color: var(--color-text-muted);
			margin: 0;
		}

		.error-message {
			color: #cf222e;
			font-size: 14px;
			margin-top: 6px;
		}

		@media (max-width: 768px) {
			.login-card {
				grid-template-columns: 1fr;
			}
			.login-visual {
				display: none;
			}
			.login-form {
				padding: 32px 24px;
			}
		}
	</style>
</head>
<body>
	<div class="login-wrapper">
		<div class="login-card">
			<div class="login-visual">
				<div class="login-visual-content">
					<?= $this->Html->image('microphone.webp', ['alt' => 'Radio Universidad']) ?>
					<h2>Radio Universidad</h2>
					<p>Sistema de Programación y Control</p>
				</div>
			</div>

			<div class="login-form">
				<div class="login-logo">
					<?= $this->Html->image('radio-levels.png', ['alt' => 'Radio Levels']) ?>
					<h2><?= $AppName ?></h2>
					<p class="subtitle">Dirección de Radio Universidad</p>
				</div>

				<?= $this->Flash->render() ?>

				<?= $this->fetch('content') ?>

				<div class="login-footer">
					<p>&copy; <?= date('Y') ?> Radio Universidad Autónoma de Sinaloa</p>
				</div>
			</div>
		</div>
	</div>

	<script src="https://kit.fontawesome.com/1451f5151b.js" crossorigin="anonymous"></script>
</body>
</html>