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
				false => '<span class="status-badge status-progress">En revisión</span>',
				true => '<span class="status-badge status-completed">Solucionado</span>',
				default => '',
			};
		} else {
			$status = '<span class="status-badge status-pending">Pendiente</span>';
		}
		
		return $status;
	}
}

