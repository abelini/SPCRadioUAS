<?php
declare(strict_types=1);

namespace SPC\Model\Entity;

use Cake\I18n\DateTime;
use Cake\ORM\Entity;



class Horario extends Entity implements \Stringable {
	
	private const int HORARIO_CULIACANAZO_ID = 8;
	
	protected array $_accessible = [
		'horaInicio' => true,
		'horaFin' => true,
		'turnoID' => true,
		'turno' => true,
		'asignaciones' => true,
		'dias' => true,
	];
	
	/**
	 * @param $which = [horaInicio, horaFin]
	 */
	public function getTimeAsString(string $which) {
		return $this->$which->format('H:i:s');
	}
	
	/*
	protected function _getHoraInicio($hora) {
		if($hora != null) {
			return $hora->i18nFormat("h a", 'en-US');
		}
		return $hora;
	}
	
	protected function _getHoraFin($hora) {
		if($hora != null) {
			if($hora->getHours() == 23 && $hora->getMinutes() == 59) {
				$hora = $hora->setTime(0, 0, 0);
			}
			return $hora->i18nFormat("h a", 'en-US');
		}
		return $hora;
	}
	*/
	/*
	public function horaInicio() {
		return $this->horaInicio->format('H:i');
	}
	
	public function horaFin() {
		if($this->horaFin->getHours() == 23 && $this->horaFin->getMinutes() == 59) {
			$this->set('horaFin', $this->horaFin->setTime(0, 0, 0));
		}
		return $this->horaFin->format('H:i');
	}*/
	
	public function __toString() : string {
		if($this->turnoID == self::HORARIO_CULIACANAZO_ID) {
			$format = 'h:mm a';
		} else {
			if($this->horaFin->getHours() == 23 && $this->horaFin->getMinutes() == 59) {
				$this->set('horaFin', $this->horaFin->setTime(0, 0, 0));
			}
			$format = 'ha';
		}
		
		return $this->horaInicio->i18nFormat($format, 'en-US').' <i class="fa-solid fa-arrow-right"></i> '. $this->horaFin->i18nFormat($format, 'en-US');
	}
}

