<?php
declare(strict_types=1);

namespace SPC\Model\Entity;

use Cake\ORM\Entity;
use NumberToWords\NumberToWords;


class ReportesPrograma extends Entity
{

	public const string REPORTING_START_DATE = 'Apr 25, 2022';

	public const string DEFAULT_STATUS = 'V';

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

	/**
	 * Convierte el conteo de reportes con status 'X' a su representación en palabras en español.
	 *
	 * @param array<string, array> $groupedByStatus Resultado de groupBy('status') con defaults aplicados
	 */
	public static function countAbsencesToWords(array $groupedByStatus): string
	{
		return NumberToWords::transformNumber('es', count($groupedByStatus[self::X]));
	}

	public function getStatusText(bool $icons = false): string
	{
		if ($icons)
			return self::STATUS_ICONS[$this->status] . ' ' . self::STATUS_LONG_OPTIONS[$this->status] ?? '-';
		else
			return self::STATUS_LONG_OPTIONS[$this->status] ?? '-';
	}
}