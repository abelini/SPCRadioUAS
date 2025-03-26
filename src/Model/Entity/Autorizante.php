<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;


class Autorizante extends Entity implements \Stringable {
    	
	public const array LISTA = [
		56, // Marisol
	];
	
	public function __toString() : string {
		return $this->name;
	}
}
