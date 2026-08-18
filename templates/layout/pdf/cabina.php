<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $this->fetch('title') ?></title>
    <?= $this->Html->meta('favicon.png', 'https://radio.uas.edu.mx/wp-content/uploads/2020/06/cropped-RADIOUAS-LOGO-IOS-32x32.png', ['type' => 'icon']) ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
    <style>
        @page {
            margin: 1cm 1cm;
            size: letter;
        }
        body {
            margin: 0;
            padding: 0;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 12pt;
            font-weight: 400;
        }
        .w3-container {
            padding: 0.01em 16px;
        }
        .w3-responsive {
            display: block;
            overflow-x: auto;
        }
        .w3-row:before,
        .w3-row:after {
            content: "";
            display: table;
            clear: both;
        }
        .w3-col {
            float: left;
            width: 100%;
        }
        .w3-white {
            color: #000 !important;
            background-color: #fff !important;
        }
        .w3-border-left {
            border-left: 1px solid #ccc !important;
        }
        .w3-border-top {
            border-top: 1px solid #ccc !important;
        }
        .w3-center {
            text-align: center !important;
        }
        .w3-text-blue-gray {
            color: #607d8b !important;
        }
        .w3-padding {
            padding: 8px 16px !important;
        }
        .w3-padding-16 {
            padding-top: 16px !important;
            padding-bottom: 16px !important;
        }
        .w3-table,
        .w3-table-all {
            border-collapse: collapse;
            border-spacing: 0;
            width: 100%;
            display: table;
        }
        .w3-table-all {
            border: 1px solid #ccc;
        }
        .w3-table-all tr {
            border-bottom: 1px solid #ddd;
        }
        .w3-table-all tr:nth-child(odd) {
            background-color: #fff;
        }
        .w3-table-all tr:nth-child(even) {
            background-color: #f1f1f1;
        }
        .w3-table td,
        .w3-table th,
        .w3-table-all td,
        .w3-table-all th {
            padding: 8px 8px;
            display: table-cell;
            text-align: left;
            vertical-align: top;
        }
        .w3-table th:first-child,
        .w3-table td:first-child,
        .w3-table-all th:first-child,
        .w3-table-all td:first-child {
            padding-left: 16px;
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

	<style>
		.top-nav {padding:1rem;display:inherit;} .logo{margin:auto;max-width:20%;min-width:15%;display:block;}
		.main {max-width:1200px;margin:0 auto;} footer {padding:32px;}
	</style>
</body>
</html>
