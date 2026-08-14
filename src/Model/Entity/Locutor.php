<?php
declare(strict_types=1);

namespace SPC\Model\Entity;

use Cake\ORM\Entity;
use Stringable;


class Locutor extends Worker implements Stringable
{

	protected array $_accessible = [
		'empleado' => true,
		'username' => true,
		'password' => true,
		'name' => true,
		'fullname' => true,
		'email' => true,
		'base' => true,
		'photo' => true,
		'asignaciones' => true,
		'reportes_cabinas' => true,
		'solicitudes' => true,
		'permisos' => true,
	];
	
	public function __toString() : string {
		return $this->name;
	}
}

