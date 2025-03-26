<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;


class TipoSolicitud extends Entity implements \Stringable {
	
	public const int GRABACION_DE_SPOT = 1;
	
	public const int MAESTRO_DE_CEREMONIA = 2;
	
	public const int CONTROL_REMOTO = 3;
	
    	public function __toString() : string {
		return $this->icon;
	}
}