<?php
declare(strict_types=1);

namespace SPC\Controller\Api;

use SPC\Controller\ApiController;
use SPC\Service\EpgBuilder;
use SPC\Service\NowPlayingService;
use Cake\Event\EventInterface;
use Cake\Http\Response;
use Cake\I18n\DateTime;
use Cake\ORM\Query\SelectQuery;


class ScheduleController extends ApiController
{
	protected const string RADIOUAS_URI = 'https://radio.uas.edu.mx';

	public function now(): Response
	{
		$nowPlaying = (new NowPlayingService())->get();
		$plainText = $nowPlaying->produccion . ' - ' . $nowPlaying->programa;

		if ($this->request->getQuery('format') === 'json') {
			return $this->render()
				->withHeader('Access-Control-Allow-Origin', self::RADIOUAS_URI)
				->withType('application/json')
				->withStringBody(json_encode($nowPlaying));
		}

		$this->viewBuilder()->setLayout(null);

		return $this->render()
			->withHeader('Access-Control-Allow-Origin', self::RADIOUAS_URI)
			->withType('text/plain')
			->withStringBody($plainText);
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

	public function si(): Response
	{
		$xml = new EpgBuilder()->buildSI();

		return $this->response
			->withHeader('Access-Control-Allow-Origin', '*')
			->withHeader('Content-Disposition', 'inline; filename="SI.xml"')
			->withType('application/xml')
			->withStringBody($xml);
	}

	public function pi(): Response
	{
		$dateParam = $this->request->getParam('date');

		try {
			$date = DateTime::createFromFormat('Ymd', substr($dateParam, 0, 8));
		} catch (InvalidArgumentException $e) {
			$date = DateTime::now();
		}

		$xml = new EpgBuilder()->buildPI($date);

		return $this->response
			->withHeader('Access-Control-Allow-Origin', '*')
			->withHeader('Content-Disposition', 'inline; filename="' . $date->format('Ymd') . '_PI.xml"')
			->withType('application/xml')
			->withStringBody($xml);
	}

	public function epg(): Response
	{
		$xml = new EpgBuilder()->buildPI(DateTime::now());

		return $this->response
			->withHeader('Access-Control-Allow-Origin', '*')
			->withHeader('Content-Disposition', 'inline; filename="PI.xml"')
			->withType('application/xml')
			->withStringBody($xml);
	}

	public function xmlEpg10(): Response
	{
		$xml = new EpgBuilder()->buildEpg10();

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

	public function beforeRender(EventInterface $event): void
	{
		$this->autoRender = false;
	}
}