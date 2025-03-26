<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;


class Update extends Entity implements \Stringable {

	protected array $_accessible = [
        'incidenciaID' => true,
        'userID' => true,
        'observacion' => true,
        'date' => true,
    ];
    
	public function __toString() : string {
		return $this->observacion;
	}
}
