<?php
declare(strict_types=1);

namespace SPC\Model\Entity;

use Cake\ORM\Entity;


class PrimerAsignado extends Entity implements \Stringable {

    	public function __toString() : string {
		return $this->name;
	}
}

