<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;


class Programa extends Entity implements \Stringable {
	
	//public string $XtoWord;
	
	protected const string UO_ICON = '<i class="fa-solid fa-school"></i>';
	
	protected const string COLABORADOR_ICON = '<i class="fa-solid fa-user"></i>';
	
	protected const string MUSICAL_ICON = '<i class="fa-solid fa-music"></i>';
	
	public const array TEMP_OUT_OF_AIR = [234,456,
		2, 	// Sinaloa al dia
		6, 	// Entre sonidos y silencios
		11, 50, // Entre universitarios
		26,	// Nocturama
		36, // La otra cara del disco
		40, // Tiempo libre
		44, // Antes de que se enfrie el cafe
		48, // Hablemos de musica (repeticion)
	];
	
	protected array $_accessible = [
		'name' => true,
		'horaInicio' => true,
		'horaFin' => true,
		'produccion' => true,
		'uo' => true,
		'musical' => true,
		'XtoWord' => true,
		'reportes' => true,
		'dias' => true,
		'reportable' => true,
	];
	
	protected array $_hidden = [
		'horaInicio',
		'horaFin',
		'music',
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
		if($this->_fields['music'])
			return self::MUSICAL_ICON;
		else
			return $this->_fields['icon'] ? self::UO_ICON : self::COLABORADOR_ICON;
	}
	
	public function __toString() : string {
		return $this->name;
	}
	
	public function isReportable() : bool {
		return (bool) $this->reportable;
	}
}
