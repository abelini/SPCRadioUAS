<?php
declare(strict_types=1);

namespace SPC\Model\Entity;

use Cake\I18n\Time;
use Cake\I18n\DateTime;
use Cake\ORM\Entity;
use Cake\Collection\Collection;
use SPC\Model\Entity\ReportesPrograma;
use Stringable;


class Programa extends Entity implements Stringable
{
	private const string SPOKEN_PROGRAMME_DEFAULT_IMAGE = 'programme-cover-0.jpeg';

	private const string MUSICAL_PROGRAMME_DEFAULT_IMAGE = 'programme-cover-99.jpeg';

	protected const string UO_ICON = '<i class="fa-solid fa-school"></i>';

	protected const string COLABORADOR_ICON = '<i class="fa-solid fa-user"></i>';

	protected const string MUSICAL_ICON = '<i class="fa-solid fa-music"></i>';

	protected const string IMAGE_CDN_URL = 'https://images.radiouas.org/';

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
		'image' => true,
		'pty' => true,
		'ptn' => true,
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
/*
	protected function _getHoraInicioString(): string
	{
		return $this->horaInicio->format('H:i:s');
	}

	protected function _getHoraFinString(): string
	{
		return $this->horaFin->format('H:i:s');
	}
*/
	protected function _getCategory(): string
	{
		if ($this->_fields['music'])
			return 'music';
		else
			return 'standard';
		// culture, science, sports, news, entertainment, children, youth, women, 
	}

	protected function _getImageUrl(): string
	{
		if ($this->_fields['image'] == null) {
			return self::IMAGE_CDN_URL . ($this->_fields['musical'] ? self::MUSICAL_PROGRAMME_DEFAULT_IMAGE : self::SPOKEN_PROGRAMME_DEFAULT_IMAGE);
		}
		return self::IMAGE_CDN_URL . $this->_fields['image'];
	}

	protected function _getIcon(): string
	{
		if ($this->_fields['musical'])
			return self::MUSICAL_ICON;
		else
			return $this->_fields['icon'] ? self::UO_ICON : self::COLABORADOR_ICON;
	}

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