<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;


class Programa extends Entity implements \Stringable {
	
	public string $XtoWord;
	
	protected const string UO_ICON = '<i class="fa-solid fa-school"></i>';
	
	protected const string COLABORADOR_ICON = '<i class="fa-solid fa-user"></i>';
	
	public const array TEMP_OUT_OF_AIR = [
		2, 	// Sinaloa al dias
		//6, 	// Entre sonidos y silencios
		11, // Entre universitarios
		26,	// Nocturama
	];
	
	protected array $_accessible = [
		'name' => true,
		'horaInicio' => true,
		'horaFin' => true,
		'produccion' => true,
		'uo' => true,
		'XtoWord' => true,
		'reportes' => true,
		'dias' => true,
		'reportable' => true,
	];
	
	protected array $_hidden = [
		'horaInicio',
		'horaFin',
		'_matchingData',
		'_joinData',
		'XtoWord',
	];
	
	protected function _getStarts() : string {
		return $this->horaInicio->i18nFormat("h:mm a", 'en-US');
	}
	
	protected function _getEnds() : string {
		return $this->horaFin->i18nFormat("h:mm a", 'en-US');
	}
	
	protected function _getIcon() : string {
		return $this->uo ? self::UO_ICON : self::COLABORADOR_ICON;
	}
	
	public function __toString() : string {
		return $this->name;
	}
	
	public function isReportable() : bool {
		return (bool) $this->reportable;
	}
}
