<?php
declare(strict_types=1);

namespace SPC\Model\Entity;

use Cake\ORM\Entity;


class Incidencia extends Entity {

	protected array $_accessible = [
		'areaID' => true,
		'fecha' => true,
		'observaciones' => true,
		'attachment' => true,
		'closed' => true,
		'created' => true,
		'modified' => true,
	];
	
	public function getPrintStatus() : string {
		if(count($this->updates) > 0) {
			$status = match($this->closed) {
				false => '<span class="w3-tag w3-round w3-orange">En revisión</span>',
				true => '<span class="w3-tag w3-round w3-green">Solucionado</span>',
				default => '',
			};
		} else {
			$status = '<span class="w3-tag w3-round w3-red">Pendiente</span>';
		}
		
		return $status;
	}
}

