<?php
declare(strict_types=1);

namespace SPC\Model\Entity;

use Cake\ORM\Entity;


class Solicitud extends Entity
{
	public const bool UNACCEPTED = false;
	public const bool ACCEPTED = true;
	public const int NOT_STARTED = 0;
	public const int RECORDING = 1;
	public const int SCHEDULED = 2;
	protected array $_accessible = [
		'tipoSolicitudID' => true,
		'solicitante' => true,
		'evento' => true,
		'observaciones' => true,
		'fecha' => true,
		'status' => true,
		'primerAsignadoID' => true,
		'segundoAsignadoID' => true,
		'autorizanteID' => true,
		'productorID' => true,
		'aceptado' => true,
		'reporteGrabacion' => true,
		'reporteProgramacion' => true,
		'preasignado' => true,
		'cancelado' => true,
		'created' => true,
		'modified' => true,
	];

	public function shortDesc(): string
	{
		return mb_substr($this->evento, 0, 120) . ' [...]';
	}

	public function getStatus(): string
	{
		$icon = '';

		if ($this->tipoSolicitudID == TipoSolicitud::SPOT_RECORDING) {
			$icon = match ($this->status) {
				self::NOT_STARTED => '<span class="pending"><i class="fa-solid fa-voicemail"></i> Grabación pendiente</span>',
				self::RECORDING => '<span class="recording"><i class="fa-solid fa-gear" title="En Grabación"></i> Grabando</span>',
				self::SCHEDULED => '<span class="accepted"><i class="fa-solid fa-calendar-days" title="Programado"></i> Programado</span>',
			};
			return $icon;
		} elseif ($this->tipoSolicitudID == TipoSolicitud::CEREMONY_MASTER) {
			$icon = match ($this->aceptado) {
				self::UNACCEPTED => '<span class="pending"><i class="fa-solid fa-circle-xmark"></i> No aceptado</span>',
				self::ACCEPTED => '<span class="accepted"><i class="fa-solid fa-check-circle" title="Aceptado"></i> Aceptado</span>',
			};
			return $icon;
		} else {
			$icon = match ($this->aceptado) {
				self::UNACCEPTED => '<span class="pending"><i class="fa-solid fa-satellite-dish"></i> En espera</span>',
				self::ACCEPTED => '<span class="accepted"><i class="fa-solid fa-satellite-dish"></i> Autorizado</span>',
			};
			return $icon;
		}
	}

	public function alreadyAccepted(): string
	{
		if ($this->tipoSolicitudID == TipoSolicitud::SPOT_RECORDING || $this->tipoSolicitudID == TipoSolicitud::CEREMONY_MASTER) {
			return $this->aceptado ? '<span class="w3-badge w3-green"></span>' : '<span class="w3-badge w3-red"></span>';
		}
		return '';
	}
}