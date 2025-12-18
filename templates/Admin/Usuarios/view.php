<div class="content">

<div class="w3-container">
	<div class="w3-card-4 w3-center w3-white">
		<div class="w3-container w3-center">
			<h1><?= $usuario->name ?></h1>
		</div>
		
		<?= $this->Html->image($usuario->getProfilePictureUrl()) ?>
		
		<div class="w3-container w3-center">
			<h2>Información</h2>
			
			<ul class="w3-ul">
				<li><i class="fa-solid fa-fingerprint"></i> Número de empleado: <?= $usuario->empleado ?></li>
				<li><i class="fa-solid fa-user"></i> <?= $usuario->fullname ?></li>
				<li><i class="fa-solid fa-envelope"></i> <?= $usuario->email ?></li>
			</ul>
			
			
			<h2>Alcance</h2>

				<div class="table-responsive">
                    <ul class="w3-ul">
                        <?php foreach ($usuario->permisos as $permiso) : ?>
                            <li><?= $permiso->icon ?> <?= $permiso->singular ?></li>
 
                        <?php endforeach; ?>
                    </ul>
				</div>
		</div>
	</div> 
</div>
</div>
<style>
	.w3-card-4 {width:<?= $usuario->getProfilePicWidth() ?>px;margin:auto;} .w3-card-4 li{color:#888;}
</style>