<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\I18n\Date;
use Cake\I18n\Time;
use Cake\ORM\Entity;


class Asignacion extends Entity {

	protected array $_accessible = [
		'rolID' => true,
		'locutorID' => true,
		'diaID' => true,
		'horarioID' => true,
		'locutor' => true,
		'dia' => true,
		'horario' => true,
	];
	
	public function classForCurrent(Date $fecha, string $className) : string {
		if($fecha->isToday()) {
			$now = Time::now();
			if($now->between($this->horario->horaInicio, $this->horario->horaFin)) {
				return $className;
			}
		}
		return '';
	}
	
}
