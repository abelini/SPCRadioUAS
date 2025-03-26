<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;


class SegundoAsignado extends Entity implements \Stringable {

    	public function __toString() : string {
		return $this->name;
	}
}
