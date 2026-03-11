<?php
declare(strict_types=1);

namespace SPC\Model\Entity;

use Cake\I18n\Time;
use Cake\I18n\DateTime;
use Cake\ORM\Entity;
use Cake\Collection\Collection;
use SPC\Model\Entity\ReportesPrograma;


class Programa extends Entity implements \Stringable
{

	//public string $XtoWord; // ahora es virtual field via _getXtoWord()

	protected const string UO_ICON = '<i class="fa-solid fa-school"></i>';

	protected const string COLABORADOR_ICON = '<i class="fa-solid fa-user"></i>';

	protected const string MUSICAL_ICON = '<i class="fa-solid fa-music"></i>';
	/*
		public const array TEMP_OUT_OF_AIR = [
			2, 	// Sinaloa al dia
			6, 	// Entre sonidos y silencios
			11, // Agenda universitaria (Entre universitarios)
			50, // Entre universitarios
			26,	// Nocturama
			36, // La otra cara del disco
			40, // Tiempo libre
			44, // Antes de que se enfrie el cafe
			48, // Hablemos de musica (repeticion)
			49, // Cacahuates japoneses
		];*/

	protected array $_accessible = [
		'name' => true,
		'categoryID' => true,
		'horaInicio' => true,
		'horaFin' => true,
		'produccion' => true,
		'conduccion' => true,
		'uo' => true,
		'musical' => true,
		'reportes' => true,
		'dias' => true,
		'reportable' => true,
		'outOfAir' => true,
	];

	protected array $_hidden = [
		'categoryID',
		'horaInicio',
		'horaFin',
		'music',
		'_matchingData',
		'_joinData',
	];

	protected function _getStarts(): string
	{
		return $this->horaInicio->i18nFormat("h:mm a", 'en-US');
	}

	protected function _getEnds(): string
	{
		return $this->horaFin->i18nFormat("h:mm a", 'en-US');
	}

	protected function _getStartTime(): Time
	{
		return $this->horaInicio;
	}

	protected function _getEndTime(): Time
	{
		return $this->horaFin;
	}

	protected function _getCategory(): string
	{
		if ($this->_fields['music'])
			return 'music';
		else
			return 'standard';
		// culture, science, sports, news, entertainment, children, youth, women, 
	}

	protected function _getIcon(): string
	{
		if ($this->_fields['music'])
			return self::MUSICAL_ICON;
		else
			return $this->_fields['icon'] ? self::UO_ICON : self::COLABORADOR_ICON;
	}

	/**
	 * Devuelve en texto (español) cuántas veces el programa no se transmitió por falta.
	 * Virtual field accesible como $programa->x_to_word o $programa->XtoWord.
	 */
	protected function _getXtoWord(): string
	{
		$summary = $this->getReportSummary();
		return ReportesPrograma::countAbsencesToWords($summary['grouped']);
	}

	/**
	 * Returns a structured summary of this program's reports grouped by status,
	 * ensuring all status keys are always present even if empty.
	 *
	 * @return array{grouped: array<string, array>, collection: Collection}
	 */
	public function getReportSummary(): array
	{
		$reportes = new Collection($this->reportes ?? []);
		$defaults = ['V' => [], 'G' => [], 'S' => [], 'X' => []];
		$grouped = array_merge($defaults, $reportes->groupBy('status')->toArray());

		return [
			'collection' => $reportes,
			'grouped' => $grouped,
		];
	}

	public function __toString(): string
	{
		return $this->name;
	}

	public function isReportable(): bool
	{
		return (bool) $this->reportable;
	}
}