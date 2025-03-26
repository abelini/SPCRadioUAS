<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;


class BitacoraCabina extends Entity implements \Stringable {

	protected array $_accessible = [
		'ID' => true,
		'fecha' => true,
		'reportes' => true,
		'created' => true,
		'modified' => true,
	  
	];
	
	public function __toString() : string {
		return 'Bitácora [#'.$this->ID.'] del día ' . $this->fecha->i18nFormat(\IntlDateFormatter::FULL);
	}
	
	public function previous() : ?BitacoraCabina {
		return TableRegistry::getTableLocator()->get($this->getSource())->find('previous', $this)->first();
	}
	
	public function next() : ?BitacoraCabina {
		return TableRegistry::getTableLocator()->get($this->getSource())->find('next', $this)->first();
	}
}
