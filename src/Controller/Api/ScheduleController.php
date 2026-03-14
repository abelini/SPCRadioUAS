<?php
declare(strict_types=1);

namespace SPC\Controller\Api;

use SPC\Controller\ApiController;
use SPC\Service\EpgBuilder;
use SPC\Trait\APICacheTrait;
use Cake\Cache\Cache;
use Cake\Http\Response;
use Cake\I18n\DateTime;
use Cake\I18n\Time;
use Cake\ORM\Query\SelectQuery;


class ScheduleController extends ApiController
{
	use APICacheTrait;

	protected const string DEFAULT_PROGRAM_NAME = 'Paisajes sonoros';

	protected const string DEFAULT_PRODUCTION_NAME = 'Fonoteca';

	protected const string RADIOUAS_URI = 'https://radio.uas.edu.mx';

	public function now(): Response
	{
		$controlRemoto = Cache::read(self::CONTROL_REMOTO_CACHE);
		$JSONFeed = null;
		$plainTextFeed = null;

		if ($controlRemoto) {
			$tiempoTranscurrido = time() - $controlRemoto['inicio'];

			if ($tiempoTranscurrido > self::MAX_REMOTE_CONTROL_TIME) {
				Cache::delete(self::CONTROL_REMOTO_CACHE);
			} else {
				$JSONFeed = [
					'programa' => $controlRemoto['evento'],
					'produccion' => $controlRemoto['produccion']
				];
				$plainTextFeed = $controlRemoto['produccion'] . ' - ' . $controlRemoto['evento'];
			}
		}

		if (!$JSONFeed) {
			$programas = $this->getTableLocator()
				->get('Programas')
				->find()
				->matching('Dias', function (SelectQuery $query) {
					return $query->where(['Dias.ID' => new DateTime()->dayOfWeek]);
				})
				->orderByAsc('horaInicio')
				->all();

			$programa = $programas->filter(function ($programa, $key) {
				$now = Time::now();
				if ($programa->horaFin->lessThan($programa->horaInicio)) {
					return $now->greaterThanOrEquals($programa->horaInicio) || $now->lessThanOrEquals($programa->horaFin);
				}
				return $now->between($programa->horaInicio, $programa->horaFin);
			});

			if ($programa->count() == 0) {
				$JSONFeed = [
					'programa' => self::DEFAULT_PROGRAM_NAME,
					'produccion' => self::DEFAULT_PRODUCTION_NAME
				];
				$plainTextFeed = self::DEFAULT_PRODUCTION_NAME . ' - ' . self::DEFAULT_PROGRAM_NAME;
			} else {
				$JSONFeed = [
					'programa' => $programa->first()->get('name'),
					'produccion' => $programa->first()->get('produccion')
				];
				$plainTextFeed = $programa->first()->get('produccion') . ' - ' . $programa->first()->get('name');
			}
		}

		$response = $this->render()
			->withHeader('Access-Control-Allow-Origin', self::RADIOUAS_URI);

		if (($this->request->getQuery('format')) !== null && $this->request->getQuery('format') == 'json') {
			return $response
				->withType('application/json')
				->withStringBody(json_encode($JSONFeed));
		}

		$this->viewBuilder()->setLayout(null);

		return $response
			->withType('text/plain')
			->withStringBody($plainTextFeed);
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

	/**
	 * Devuelve el EPG en formato XML (RadioDNS EPG v10)
	 * con toda la programación semanal
	 *
	 * GET /api/schedule/xml
	 */
	public function xml(): Response
	{
		$this->autoRender = false;

		$xml = (new EpgBuilder())->build();

		return $this->response
			->withHeader('Access-Control-Allow-Origin', '*')
			->withHeader('Content-Disposition', 'inline; filename="epg.xml"')
			->withType('application/xml')
			->withStringBody($xml);
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