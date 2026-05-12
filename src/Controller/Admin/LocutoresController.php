<?php
declare(strict_types=1);

namespace SPC\Controller\Admin;

use SPC\Controller\AppController;
use Cake\Collection\Collection;
use Cake\Database\Expression\QueryExpression;
use Cake\Http\Response;
use Cake\I18n\DateTime;
use Cake\ORM\Query\SelectQuery;


class LocutoresController extends AppController
{

	protected const int PRIMERA_QUINCENA = 1;
	protected const int SEGUNDA_QUINCENA = 2;
	protected const int HORAS_EXTRAS_POR_TURNO = 6;
	protected const int HORAS_EXTRAS_POR_EVENTO = 4;
	protected const array DIAS_INHABILES = [
		'Feb 5th',
		'Mar 21st',
		'Apr 21st',
		'May 1st',
		'May 5th',
		'May 10th',
		'Sep 16th',
		'Nov 1st',
		'Nov 2nd',
		'Nov 20th',
	];

	public function horasExtras(): Response
	{
		$today = parent::$datetime;
		$quincenaDelMes = ($today->day >= 1 && $today->day <= 15) ? self::SEGUNDA_QUINCENA : self::PRIMERA_QUINCENA;

		$today = ($quincenaDelMes == self::SEGUNDA_QUINCENA) ? $today->modify('-1 month') : $today;

		$empieza = match ($quincenaDelMes) {
			self::PRIMERA_QUINCENA => $today->startOfMonth(),
			self::SEGUNDA_QUINCENA => $today->day(16),
		};
		$termina = match ($quincenaDelMes) {
			self::PRIMERA_QUINCENA => $today->day(15),
			self::SEGUNDA_QUINCENA => $today->endOfMonth(),
		};

		$feriadosDeLaQuincena = array();

		foreach (self::DIAS_INHABILES as $feriado) {
			$feriado = new DateTime($feriado);
			if ($feriado->isWeekday()) {
				if ($feriado->between($empieza, $termina)) {
					array_push($feriadosDeLaQuincena, $feriado);
				}
			}
		}

		$locutoresAsignados = $this->Locutores->find('DiasFeriadosAsignados', diasFeriados: $feriadosDeLaQuincena, today: $today)->all();

		$locutores = new Collection($this->Locutores->find()->where(['base' => true])->all());
		$horasXCabina = array();
		$horasXEvento = array();

		foreach ($locutores as $id => $locutor) {
			$asignaciones = (new Collection($locutoresAsignados))->match(['ID' => $locutor->ID]);
			if ($asignaciones->isEmpty()) {
				continue;
			}

			$horasXCabina[$id] = [
				'locutor' => $locutor,
				'horas' => $asignaciones->count() * self::HORAS_EXTRAS_POR_TURNO,
			];
		}

		$maestrosAsignados = $this->Locutores->find('MaestrosAsignados', empieza: $empieza, termina: $termina)->all();

		foreach ($locutores as $id => $locutor) {
			$eventos = (new Collection($maestrosAsignados))->match(['ID' => $locutor->ID]);
			if ($eventos->isEmpty()) {
				continue;
			}

			$horasXEvento[$id] = [
				'locutor' => $locutor,
				'horas' => $eventos->count() * self::HORAS_EXTRAS_POR_EVENTO,
				'eventos' => $eventos->extract('_matchingData.Solicitudes')->toList(),
			];
		}

		$this->set(compact('empieza', 'termina'));
		$this->set(compact('feriadosDeLaQuincena', 'horasXCabina', 'horasXEvento'));

		return $this->render();
	}

	public function index(): Response
	{
		$query = $this->Locutores->find();
		$locutores = $this->paginate($query);
		$this->set(compact('locutores'));
		return $this->render();
	}

	public function view($id = null): Response
	{
		$locutore = $this->Locutores->get($id, contain: ['Permisos', 'Asignaciones']);
		$this->set(compact('locutore'));
		return $this->render();
	}

}

