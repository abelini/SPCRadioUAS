<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;


class ReportesCabina extends Entity {
	
	private const string REMOTE_CONTROL_ICON = '<i class="fa-solid fa-satellite-dish"></i>';
	
	protected array $_accessible = [
		'ID' => true,
		'bitacoraID' => true,
		'locutorID' => true,
		'horaInicio' => true,
		'horaFin' => true,
		'reporte' => true,
		'controles' => true,
		'created' => true,
		'modified' => true,
		'reportes_programas' => true,
	];
	
	public function getPrintableReport() : string {
		$lines = explode("\n", trim($this->reporte));
		foreach ($lines as $l => $line) {
			if(!empty($line))
				$lines[$l] = self::REMOTE_CONTROL_ICON . ' ' . mb_strtoupper($lines[$l]);
		}
		$this->set('reporte', nl2br(implode("\n", $lines)));
		return empty(trim($this->reporte))? 'N/A' : $this->reporte;
	}
	/*
	protected function _getReporte($reporte) {
		if($reporte == null || $reporte == 'Sin novedad') {
			return '';
		}
		return $reporte;
	}*/
}
