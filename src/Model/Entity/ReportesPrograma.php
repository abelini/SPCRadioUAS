<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;


class ReportesPrograma extends Entity {
	
	public const string REPORTING_START_DATE = 'May 1, 2022';
		
	protected const string V = 'V';
	
	protected const string G = 'G';
	
	protected const string S = 'S';
	
	protected const string X = 'X';
	
	protected array $_accessible = [
		'ID' => true,
		'ReporteCabinaID' => true,
		'programaID' => true,
		'status' => true,
		'reporte' => true,
		'programa' => true,
	];
	
	protected array $_hidden = [
		'_matchingData' => true,
	];
	
	public const array STATUS_OPTIONS = [
		self::V => 'V',
		self::G => 'G',
		self::S => 'S',
		self::X => 'X',
	];
	
	public const array STATUS_LONG_OPTIONS = [
		self::V => 'En vivo',
		self::G => 'Grabado',
		self::S => 'Suspendido',
		self::X => 'Falta',
	];
	
	public const array STATUS_LONGTEXT_FOR_1P = [
		self::V => 'Transmisiones en vivo',
		self::G => 'Transmisiones en grabación',
		self::S => 'El programa se suspendió',
		self::X => 'No se transmitió por falta',
	];
	
	protected const array STATUS_ICONS = [
		self::V => '<i class="fa-solid fa-microphone-lines w3-text-green"></i>',
		self::G => '<i class="fa-solid fa-circle w3-text-red"></i>',
		self::S => '<i class="fa-solid fa-microphone-lines-slash"></i>',
		self::X => '<i class="fa-solid fa-circle-xmark w3-highway-text-red"></i>',
	];
	
	public function getStatusText(bool $icons = false) : string {
		if($icons)
			return self::STATUS_ICONS[$this->status] . ' ' . self::STATUS_LONG_OPTIONS[$this->status] ?? '-';
		else
			return self::STATUS_LONG_OPTIONS[$this->status] ?? '-';
	}
}
