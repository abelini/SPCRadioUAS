<?php
declare(strict_types=1);

namespace SPC\Model\Entity;

use Cake\ORM\Entity;


class Autorizante extends Entity implements \Stringable {
    	
	public const int DIRECTOR = 52;
	
	public function __toString() : string {
		return $this->name;
	}
}

