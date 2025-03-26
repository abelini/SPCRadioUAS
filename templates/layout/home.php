<!DOCTYPE html>
<html>
<head>
	<?= $this->Html->charset() ?>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="robots" content="noindex, nofollow">
	<title><?= $AppName ?></title>
	<?= $this->Html->meta('favicon.png', 'https://radio.uas.edu.mx/wp-content/uploads/2020/06/cropped-RADIOUAS-LOGO-IOS-32x32.png', ['type' => 'icon']) ?>
	<?= $this->Html->css(['normalize.min', 'milligram.min',  'cake',]) ?>
	<?= $this->fetch('meta') ?>
	<?= $this->fetch('css') ?>
	<?= $this->fetch('script') ?>
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<?= $this->Html->css(['custom']) ?>
	<style stype="text/css">
		@import url('https://fonts.googleapis.com/css2?family=Khand:wght@300;400&display=swap');
	</style>
</head>
<body>
	<main class="">
        <div class="">

			<div class="">

				<div class="w3-card-4 reg-modal">
					<div class="w3-row">
						<div class="w3-half w3-center">
							<?= $this->Html->image('microphone.webp')?>
						</div>
						<div class="w3-half w3-white w3-center w3-padding login">
							
							<h1>Radio Universidad Autónoma de Sinaloa</h1>
							
							<h2><?= $AppName ?></h2>
							
							<?= $this->Html->image('logo.png', ['class' => 'logo w3-image w3-center'])?>
							
							<?= $this->Flash->render() ?>
							
							<?= $this->fetch('content') ?>			
								
							<?= $this->Html->image('iloveuas.png', ['class' => 'iloveuas w3-center w3-image'])?>
								
							<p class="w3-center w3-small">
								Dirección de Radio Universidad Autónoma de Sinaloa<br/>&reg; 2024
							</p>
						</div>
					</div>
				</div>
		
			</div>
		<style>
			body{background:#111 url('<?= $this->Url->image('bg.webp')?>') no-repeat; background-size:cover;}
			.error-message {color:#d33c43;} .login{min-height:799px;}
			/*
			 button{letter-spacing:0;height:48px;} p{margin-bottom:0;display:block;} 
			.w3-display-topmiddle, .w3-display-bottommiddle{width:100%;} .w3-text-red{color:#d33c43 !important;} .w3-red{background-color:#d33c43 !important;}

			 .w3-modal-content{width:100%;} img.modal{cursor:pointer;}
			p{color:#666;text-align:left;padding:12px;} p.title{font-weight:bold;} .date{font-weight:lighter;color:#aaa;}
			*/
			h1{line-height:45px;font-size:45px;letter-spacing:1px;} h2{font-size:30px;letter-spacing:1px;}
			.logo{max-width:35%;} .iloveuas{max-width:15%;} p,h2{color:#aaa;}
			
			@media only screen and (min-width:1200px) {
				.reg-modal{width:100%;margin:0;}
				.logo-small{width:128px;margin:64px auto 128px;}
				.reg-modal {width:900px;margin:48px auto 0;height:700px;overflow:hidden;}
			}
			@media only screen and (min-width: 1200px) {
				.logo-small {
					width: 128px;margin: 48px auto 24px;
				}
			}*/
		</style>  


        </div>
    </main>
    <footer>
    </footer>
	<script src="https://kit.fontawesome.com/1451f5151b.js" crossorigin="anonymous"></script>
</body>
</html>
