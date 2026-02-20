<?php
declare(strict_types=1);

namespace SPC\Controller\Api;

use SPC\Controller\ApiController;
use Cake\Cache\Cache;
use Cake\Http\Response;
use Cake\I18n\DateTime;
use Cake\I18n\Time;
use Cake\ORM\Query\SelectQuery;


class ScheduleController extends ApiController
{

	protected const string DEFAULT_RADIOFEED_TEXT = 'Fonoteca - Paisajes sonoros';

	protected const array DEFAULT_PROGRAM = ['programa' => 'Paisajes sonoros', 'produccion' => 'Fonoteca'];

	protected const string RADIOUAS_URI = 'https://radio.uas.edu.mx';

	private const int MAX_REMOTE_CONTROL_TIME = 2 * 60 * 60;

	public function now(): Response
	{
		$controlRemoto = Cache::read('control_remoto_activo');
		$feedArray = null;
		$feedText = null;

		if ($controlRemoto) {
			$tiempoTranscurrido = time() - $controlRemoto['inicio'];

			if ($tiempoTranscurrido > self::MAX_REMOTE_CONTROL_TIME) {
				Cache::delete('control_remoto_activo');
			} else {
				$feedArray = [
					'programa' => $controlRemoto['programa'],
					'produccion' => $controlRemoto['produccion']
				];
				$feedText = $controlRemoto['produccion'] . ' - ' . $controlRemoto['programa'];
			}
		}

		if (!$feedArray) {
			$today = DateTime::now();
			$programas = $this->getTableLocator()
				->get('Programas')
				->find()
				->where(['Programas.outOfAir' => false])
				->matching('Dias', function (SelectQuery $query) {
					return $query->where(['Dias.ID' => (new DateTime())->dayOfWeek]);
				})
				->orderByAsc('horaInicio')
				->all();

			$programa = $programas->filter(function ($programa, $key) {
				$now = Time::now();
				return $now->between($programa->horaInicio, $programa->horaFin);
			});

			if ($programa->count() == 0) {
				$feedArray = self::DEFAULT_PROGRAM;
				$feedText = self::DEFAULT_RADIOFEED_TEXT;
			} else {
				$feedArray = [
					'programa' => $programa->first()->get('name'),
					'produccion' => $programa->first()->get('produccion')
				];
				$feedText = $feedArray['produccion'] . ' - ' . $feedArray['programa'];
			}
		}

		if (($this->request->getQuery('format')) !== null && $this->request->getQuery('format') == 'json') {
			return $this->render()
				->withHeader('Access-Control-Allow-Origin', self::RADIOUAS_URI)
				->withType('application/json')
				->withStringBody(json_encode($feedArray));
		}

		$this->viewBuilder()->setLayout(null);

		return $this->render()
			->withHeader('Access-Control-Allow-Origin', self::RADIOUAS_URI)
			->withType('text/plain')
			->withStringBody($feedText);
	}

	public function daily(): Response
	{
		if (($this->request->getQuery('source')) !== null && $this->request->getQuery('source') == 'mobile-app') {
			$select = [
				'ID',
				'name',
				'horaInicio',
				'horaFin',
				'subtitle' => 'produccion',
				'categoryID',
				'music' => 'musical',
				'startTime' => 'horaInicio',
				'endTime' => 'horaFin',
			];
		} else {
			$select = [
				'name',
				'horaInicio',
				'horaFin',
				'produccion',
				'icon' => 'uo',
				'music' => 'musical',
				'starts' => 'horaInicio',
				'ends' => 'horaFin',
			];
		}
		$day = $this->getRequestedDay();
		$programas = $this->getTableLocator()
			->get('Programas')
			->find()
			->select($select)
			->where(['Programas.outOfAir' => false])
			->contain('CategoriasProgramas', function (SelectQuery $query) {
				return $query->select(['ID', 'slug']);
			})
			->matching('Dias', function (SelectQuery $query) use ($day) {
				return $query->where(['Dias.ID' => $day]);
			})
			->orderByAsc('horaInicio')
			->all()
			->toArray();

		foreach ($programas as $id => $programa) {
			$programas[$id]['dayOfWeek'] = $day;
			$programas[$id]['slug'] = $programa->categoria->slug;
			unset($programas[$id]['categoria']);
		}

		return $this->render()
			->withHeader('Access-Control-Allow-Origin', self::RADIOUAS_URI)
			->withType('application/json')
			->withStringBody(json_encode($programas));
	}

	protected function getRequestedDay(): int
	{
		$day = $this->request->getQuery('day');
		if (ctype_digit($day) && $day >= 1 && $day <= 7) {
			return (int) $day;
		} else {
			return (new DateTime())->dayOfWeek;
		}
	}
}

