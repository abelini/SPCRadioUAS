<?php
declare(strict_types=1);

namespace SPC\Controller\Api;

use Cake\Cache\Cache;
use SPC\Controller\ApiController;
use SPC\DTO\StreamData;
use SPC\Service\EpgBuilder;
use SPC\Service\NowPlayingService;
use Cake\Event\EventInterface;
use Cake\Http\Response;
use Cake\I18n\DateTime;
use Cake\ORM\Query\SelectQuery;


class ScheduleController extends ApiController
{
	protected const string RADIOUAS_URI = 'https://radio.uas.edu.mx';
	protected const string OVERRIDE_CACHE_KEY = 'schedule_override';
	protected const string SCHEDULE_CACHE_CONFIG = 'programas_api';

	public function now(): Response
	{
		$nowPlaying = $this->getOverrideStreamData() ?? (new NowPlayingService())->get();
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

	private function getOverrideStreamData(): ?StreamData
	{
		$override = Cache::read(self::OVERRIDE_CACHE_KEY, self::SCHEDULE_CACHE_CONFIG);
		if ($override === null) {
			return null;
		}

		if ($override['expires_at'] < time()) {
			Cache::delete(self::OVERRIDE_CACHE_KEY, self::SCHEDULE_CACHE_CONFIG);
			return null;
		}

		return new StreamData(
			programa: $override['programa'],
			produccion: $override['produccion'],
			pty: 0,
			ptn: '',
			music: (bool) $override['music'],
			sm: (bool) $override['music'],
		);
	}

	public function daily(): Response
	{
		if (($this->request->getQuery('source')) !== null && $this->request->getQuery('source') == 'mobile-app') {
			$fields = [
				'ID',
				'name',
				'horaInicio',
				'horaFin',
				'image',
				'subtitle' => 'produccion',
				'categoryID',
				'music' => 'musical',
				'startTime' => 'horaInicio',
				'endTime' => 'horaFin',
			];
		} else {
			$fields = [
				'name',
				'horaInicio',
				'horaFin',
				'image',
				'produccion',
				'icon' => 'uo',
				'music' => 'musical',
				'starts' => 'horaInicio',
				'ends' => 'horaFin',
			];
		}

		$override = Cache::read(self::OVERRIDE_CACHE_KEY, self::SCHEDULE_CACHE_CONFIG);
		if ($override !== null && $override['expires_at'] < time()) {
			Cache::delete(self::OVERRIDE_CACHE_KEY, self::SCHEDULE_CACHE_CONFIG);
			$override = null;
		}
		if ($override !== null) {
			return $this->response
				->withHeader('Access-Control-Allow-Origin', self::RADIOUAS_URI)
				->withType('application/json')
				->withStringBody(json_encode($this->buildOverrideEntry($override)));
		}

		$day = $this->getRequestedDay();
		$programas = $this->getTableLocator()
			->get('Programas')
			->find()
			->select($fields)
			->contain('CategoriasProgramas', fn(SelectQuery $query) => $query->select(['ID', 'slug']))
			->matching('Dias', fn(SelectQuery $query) => $query->where(['Dias.ID' => $day]))
			->orderByAsc('horaInicio')
			->all();

		$result = [];
		foreach ($programas as $programa) {
			$entry = $programa->toArray();
			$entry['image'] = $programa->image_url;
			unset($entry['image_url']);
			$entry['dayOfWeek'] = $day;
			$entry['slug'] = $programa->categoria->slug;
			unset($entry['categoria']);
			$result[] = $entry;
		}

		return $this->response
			->withHeader('Access-Control-Allow-Origin', self::RADIOUAS_URI)
			->withType('application/json')
			->withStringBody(json_encode($result));
	}

	private function buildOverrideEntry(array $override): array
	{
		$timeParts = explode(':', $override['hora_inicio']);
		$hours = (int) ($timeParts[0] ?? 0);
		$minutes = (int) ($timeParts[1] ?? 0);

		$start = DateTime::now();
		$start->setTime($hours, $minutes);
		$end = clone $start;
		$end->modify('+' . $override['duration_minutes'] . ' minutes');

		return [
			'name' => $override['programa'],
			'horaInicio' => $start->format('H:i'),
			'horaFin' => $end->format('H:i'),
			'image' => '',
			'produccion' => $override['produccion'],
			'icon' => null,
			'music' => (bool) $override['music'],
			'starts' => $start->format('H:i'),
			'ends' => $end->format('H:i'),
		];
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
		} catch (\InvalidArgumentException $e) {
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
			return new DateTime()->dayOfWeek;
		}
	}

	public function beforeRender(EventInterface $event): void
	{
		$this->autoRender = false;
	}
}