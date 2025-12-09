<?php
declare(strict_types=1);

namespace SPC\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;


class Rol extends Entity {
	
	protected array $_accessible = [
		'fechaInicio' => true,
		'fechaFin' => true,
		'turnoID' => true,
		'turno' => true,
		'asignaciones' => true,
	];
	
	public function previous() : ?Rol {
		return TableRegistry::getTableLocator()->get($this->getSource())->find('previous', rol:$this)->first();
	}
	
	public function next() : ?Rol {
		return TableRegistry::getTableLocator()->get($this->getSource())->find('next', rol:$this)->first();
	}
}

