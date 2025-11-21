<?php $outterTR = 1; $innerTR = 1;?>

<div style="padding:16px;color:#000!important;background-color:#dbe1ea !important;min-height:124px;">
	<?= $this->Html->image($this->Url->image('logo2029.webp', ['fullBase' => true]), ['style' => 'display:block;float:right;max-width:124px;'])?>
	<h2>Hola <?= $user->name ?></h2>
	
</div>
<div style="margin-top:16px!important;margin-bottom:16px!important;">

	<p>Has solicitado la recuperación de tu contraseña. Como no podemos adivinarla, te generamos una nueva:</p>
	
</div>	

<div style="padding:0.01em 16px;color:#1a2b4c!important;">
	<p style="text-align:center;font-size:36px;letter-spacing:4px;padding-bottom:12px;"><?= $password ?></p>
	<p style="text-align:center;"><?= $this->Html->image($this->Url->image('lost-password.png', ['fullBase' => true]), ['style' => 'max-width:240px;margin:auto;display:block;'])?></p>
</div>

<div style="margin-top:16px!important;margin-bottom:16px!important;">

	<p>Una vez que inicies sesión con ella, podrás cambiarla desde tu perfil.</p>
	
</div>	
	
<div style="padding:4px;width:100%;background-color:#0094cd;color:#fff;">
	<p style="text-align:center">A T E N T A M E N T E</p>
	<p style="text-align:center">Ing. Abel Bottello</p>
</div>

<div style="padding:4px;width:100%;background-color:#1a2b4c;color:#0094cd;">
	<p style="text-align:center">Departamento de Sistemas de Radio UAS © <?= date('Y')?></p>
</div>