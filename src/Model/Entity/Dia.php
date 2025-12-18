<?php
declare(strict_types=1);

namespace SPC\Model\Entity;

use Cake\ORM\Entity;


class Dia extends Entity implements \Stringable {

	protected array $_accessible = [
		'name' => true,
		'asignaciones' => true,
		'horarios' => true,
		'programas' => true,
	];
	
	public function __toString() : string {
		return mb_strtolower($this->name);
	}
}

