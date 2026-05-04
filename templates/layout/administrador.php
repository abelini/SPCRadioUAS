<!DOCTYPE html>
<html lang="es">

<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $AppName ?></title>
    <?= $this->Html->meta('favicon.png', 'https://radio.uas.edu.mx/wp-content/uploads/2020/06/cropped-RADIOUAS-LOGO-IOS-32x32.png', ['type' => 'icon']) ?>

    <?= $this->Html->css('github-midnight') ?>
    <?= $this->Html->script('jquery-3.7.1') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>

<body>
    <div class="admin-layout">
        <nav class="admin-sidebar" id="menu">
            <div class="admin-sidebar-header">
                <?= $this->Html->image('radio-levels-wh.png', ['alt' => 'Logo']) ?>
                <span class="title"><?= $this->Html->link($AppName, ['controller' => 'dashboard']) ?></span>
            </div>

            <div class="admin-sidebar-nav">
                <?= $this->Html->link('<i class="fa-solid fa-microphone-lines"></i> Roles de Cabina', ['controller' => 'roles'], ['escape' => false]) ?>
                <?= $this->Html->link('<i class="fa-regular fa-folder-open"></i> Solicitudes', ['controller' => 'solicitudes'], ['escape' => false]) ?>
                <?= $this->Html->link('<i class="fa-regular fa-clock"></i> Horas extras', ['controller' => 'locutores', 'action' => 'horas_extras'], ['escape' => false]) ?>
                <?= $this->Html->link('<i class="fa-solid fa-radio"></i> Programas', ['controller' => 'programas'], ['escape' => false]) ?>
                <?= $this->Html->link('<i class="fa-solid fa-file-contract"></i> Bitácora de cabina', ['controller' => 'bitacora_cabina'], ['escape' => false]) ?>
                <?= $this->Html->link('<i class="fa-solid fa-file-signature"></i> Registro de incidencias', ['controller' => 'incidencias'], ['escape' => false]) ?>
                <?= $this->Html->link('<i class="fa-solid fa-chart-pie"></i> Reportes de cabina', ['controller' => 'reportes_cabinas', 'action' => 'reportes'], ['escape' => false]) ?>
                <?= $this->Html->link('<i class="fa-solid fa-users"></i> Usuarios', ['controller' => 'usuarios'], ['escape' => false]) ?>
                <?= $this->Html->link('<i class="fa-solid fa-align-left"></i> Temas de programas', ['controller' => 'TemasProgramas', 'action' => 'index'], ['escape' => false]) ?>
                <?= $this->Html->link('<i class="fa-solid fa-align-left"></i> Categorías de programas', ['controller' => 'CategoriasProgramas', 'action' => 'index'], ['escape' => false]) ?>
                <?= $this->Html->link('<i class="fa-solid fa-tv"></i> Control de Streaming', ['controller' => 'stream'], ['escape' => false]) ?>
                <?= $this->Html->link('<i class="fa-solid fa-chart-simple"></i> Uso de streaming', ['controller' => 'StreamHits', 'action' => 'index'], ['escape' => false]) ?>

                <?= $this->Html->link('<i class="fa-solid fa-right-from-bracket"></i> Salir', ['controller' => 'usuarios', 'action' => 'logout'], ['class' => 'nav-logout', 'escape' => false]) ?>

                <a href="#" class="admin-sidebar-close" onclick="w3_close()"><i class="fa-solid fa-angles-left"></i></a>
            </div>
        </nav>

        <main class="admin-main">
            <header class="admin-header">
                <button class="mobile-menu-btn" onclick="w3_open()">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </header>

            <div class="admin-content">
                <?= $this->Flash->render() ?>
                <?= $this->fetch('content') ?>
            </div>

            <footer class="admin-footer">
                <p>Dirección de Radio Universidad Autónoma de Sinaloa &copy; <?= $datetime->format('Y') ?></p>
            </footer>
        </main>
    </div>

    <script src="https://kit.fontawesome.com/18176e4df9.js" crossorigin="anonymous"></script>
    <script>
        function w3_open() {
            document.getElementById("menu").classList.add("open");
        }

        function w3_close() {
            document.getElementById("menu").classList.remove("open");
        }
    </script>
</body>

</html>