<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;


class Area extends Entity implements \Stringable {

	protected array $_accessible = [
		'name' => true,
		'icon' => true,
	];
	
	public function __toString() : string {
		return $this->icon . ' ' .$this->name;
	}
}
