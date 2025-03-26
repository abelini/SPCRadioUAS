<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;
use App\Model\Entity\TurnoVigilancia;


class TipoBitacora extends Entity {

	protected array $_accessible = [
		'name' => true,
		'turnos' => true,
	];
	
	public function getPrintableTurnos() {
		$turnos = json_decode($this->turnos, flags:JSON_OBJECT_AS_ARRAY);
		foreach($turnos as $id => $turno) {
			$turnos[$id] = new TurnoVigilancia($turno);
		}
		
		$html = '<ul class="w3-ul">';
		foreach($turnos as $turno) {
			
			$html .= 	'<li>'. $turno->name . '</li>';
			$html .= 	'<li>';
			$html .= 		'<ul class="w3-ul">';
			$html .= 			'<li>'. $turno->starts . '</li>';
			$html .= 			'<li>'. $turno->ends . '</li>';
			$html .= 		'</ul>';
			$html .= 	'</li>';
		}
		
		$html .= '</ul>';
		
		return $html;
	}
	
}
