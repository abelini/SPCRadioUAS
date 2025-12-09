<?php
declare(strict_types=1);

namespace SPC\Model\Entity;

use Cake\ORM\Entity;


class Solicitud extends Entity {
	
	public const int NOT_STARTED = 0;
	
	public const int RECORDING = 1;
	
	public const int SCHEDULED = 2;
	
	protected array $_accessible = [
        'tipoSolicitudID' => true,
        'solicitante' => true,
        'evento' => true,
        'observaciones' => true,
        'fecha' => true,
        'status' => true,
        'primerAsignadoID' => true,
        'segundoAsignadoID' => true,
        'autorizanteID' => true,
        'productorID' => true,
        'aceptado' => true,
        'reporteGrabacion' => true,
        'reporteProgramacion' => true,
        'preasignado' => true,
        'cancelado' => true,
        'created' => true,
        'modified' => true,
	];
	
	public function shortDesc() : string {
		return mb_substr($this->evento, 0, 120) . ' [...]';
	}
	
	public function getStatus() : string {
		if($this->tipoSolicitudID == 1) {
			$icon = match($this->status) {
				self::NOT_STARTED => '<i class="fa-solid fa-clipboard-check w3-text-red"></i>', 
				self::RECORDING => '<i class="fa-solid fa-gear w3-text-orange"></i>',
				self::SCHEDULED => '<i class="fa-solid fa-calendar-days w3-text-green"></i>',
			};
			return $icon;
		}
		return '';
	}
	
	public function alreadyAccepted() : string {
		if($this->tipoSolicitudID == 1 || $this->tipoSolicitudID == 2) {
			return $this->aceptado ? '<span class="w3-badge w3-green"></span>' : '<span class="w3-badge w3-red"></span>';
		}
		return '';
	}
	
}

