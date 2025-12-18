<?php
declare(strict_types=1);

namespace SPC\Model\Entity;

use Cake\I18n\Time;


class TurnoVigilancia {
	
	public string $name;
	
	public Time $starts;
	
	public Time $ends;
	
	public function __construct(array $turno) {
		foreach($turno as $name => $hours) {
			$this->name = $name;
			$this->starts = new Time($hours[0]);
			$this->ends = new Time($hours[1]);
		}
	}
}
