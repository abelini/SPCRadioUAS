<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reporte</title>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
    <style>
        @page {
            size: letter;
            margin: 10mm;
        }
        :root {
            --color-paper: #f6f8fa;
            --color-border-subtle: #d8dee4;
            --color-ink: #1f2328;
            --color-muted-gray: #656d76;
            --color-polar-blue: #0969da;
            --color-spring-green: #1a7f37;
            --color-blue-violet-orb: #8250df;
            --color-vapor-trail-blue: #218bda;
            --color-faded-silver: #f0f6fc;
            --color-subtle-gray: #d8dee4;
            --color-ghost-white: #ffffff;
            --color-galaxy-blue: #2A4B7C;
            --color-green: #22c55e;
            --color-yellow: #d29922;
            --color-orange: #f59e0b;
            --color-blue: #3b82f6;
            --color-red: #ef4444;
            --surface-paper: #f6f8fa;
            --radius-md: 6px;
            --radius-cards: 8px;
            --font-weight-medium: 500;
            --spacing-4: 4px;
            --spacing-8: 8px;
            --spacing-10: 10px;
            --spacing-12: 12px;
            --spacing-14: 14px;
            --spacing-16: 16px;
            --spacing-20: 20px;
            --spacing-24: 24px;
        }
        body {
            margin: 0;
            padding: 0;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 10pt;
            font-weight: 400;
            color: #1f2328;
            line-height: 1.5;
        }
        h1, h2, h3, h4, h5, h6 {
            font-weight: 500;
            text-transform: uppercase;
            color: #1f2328;
            margin: 0;
        }
        h1 { font-size: 20pt; }
        h2 { font-size: 17pt; }
        h3 { font-size: 14pt; }
        h4 { font-size: 12pt; }
        h5 { font-size: 10.5pt; }
        h6 { font-size: 9pt; }

        .top-nav { padding: 1rem; display: inherit; }
        .top-nav-title { text-align: center; }
        .logo { margin: auto; max-width: 15%; min-width: 10%; display: block; }
        .main { max-width: 1100px; margin: 0 auto; }
        footer { padding: 32px; }

        .w3-container { padding: 0.01em 16px; }
        .w3-galaxy-blue {
            color: #fff !important;
            background-color: #2A4B7C !important;
        }

        /* Page headers */
        .page-header {
            background: linear-gradient(135deg, var(--color-vapor-trail-blue) 0%, var(--color-blue-violet-orb) 100%);
            border: none;
            border-radius: var(--radius-cards) var(--radius-cards) 0 0;
            padding: var(--spacing-16) var(--spacing-24);
            margin-bottom: 0;
        }
        .page-header h4,
        .page-header h5 {
            margin: 0;
            color: #ffffff;
            text-transform: uppercase;
            font-size: 13.5pt;
        }
        .page-subheader {
            background: linear-gradient(135deg, rgba(9, 105, 218, 0.06) 0%, rgba(130, 80, 223, 0.06) 100%);
            border: 1px solid var(--color-border-subtle);
            border-radius: var(--radius-cards) var(--radius-cards) 0 0;
            padding: var(--spacing-12) var(--spacing-20);
            margin-bottom: 0;
        }
        .page-subheader h4,
        .page-subheader h5 {
            margin: 0;
            color: var(--color-polar-blue);
            font-size: 12pt;
        }

        /* Grid */
        .row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 calc(-1 * var(--spacing-8));
        }
        .row > [class*="col-"] {
            padding: 0 var(--spacing-8);
            box-sizing: border-box;
        }
        .g-3 { gap: 0; }
        .col-12 { width: 100%; }
        .col-md-6 { width: 50%; }
        .col-lg-3 { width: 25%; }
        .col-lg-9 { width: 75%; }

        /* Enlaces remotos */
        .cr-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            flex-wrap: wrap;
        }
        .cr-list li {
            flex: 0 0 50%;
            box-sizing: border-box;
            display: flex;
            align-items: baseline;
            gap: var(--spacing-12);
            padding: 6px 12px;
            border-bottom: 1px solid #ccc;
            overflow-wrap: anywhere;
        }
        .cr-list li .cr-name {
            flex: 1;
            color: var(--color-ink);
            font-weight: var(--font-weight-medium);
            text-transform: uppercase;
            font-size: 10pt;
        }
        .cr-list li .cr-date {
            color: var(--color-muted-gray);
            font-size: 9pt;
            white-space: nowrap;
        }

        /* Barras de cumplimiento */
        .bar {
            display: block;
            height: 18px;
            border-radius: 4px;
            color: #fff;
            font-size: 9pt;
            font-weight: 500;
            line-height: 18px;
            text-align: center;
        }
        .bar-green { background: var(--color-green); }
        .bar-yellow { background: var(--color-yellow); }
        .bar-orange { background: var(--color-orange); }
        .bar-red { background: var(--color-red); }
        .bar-label {
            font-size: 10pt;
            font-weight: 500;
            text-transform: uppercase;
            margin: 0 0 var(--spacing-4);
        }
        .mini-bar {
            display: block;
            height: 22px;
            border-radius: 4px;
            color: #fff;
            font-size: 9pt;
            font-weight: 500;
            line-height: 22px;
            text-align: center;
            box-sizing: border-box;
            padding: 0 6px;
            margin: var(--spacing-4) auto 0;
        }
    </style>
</head>
<body>
	<nav class="top-nav">
		<div class="top-nav-title">
			<?= $this->Html->image('LogoRolCabinaPDF.png', ['class' => 'logo', 'fullBase' => true])?>
        </div>
	</nav>
	<main class="main">
        <div class="w3-container">
			<?= $this->fetch('content') ?>
        </div>
	</main>
</body>
</html>