<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;


class PermisosUsuario extends Entity {

	protected array $_accessible = [
		'usuarioID' => true,
		'permisoID' => true,
		'usuario' => true,
		'permiso' => true,
	];
}
