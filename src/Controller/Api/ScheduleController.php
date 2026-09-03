<?php
declare(strict_types=1);

namespace SPC\Controller\Api;

use Cake\Event\EventInterface;
use Cake\Http\Response;
use Cake\I18n\DateTime;
use Cake\I18n\Time;
use Cake\ORM\Query\SelectQuery;
use SPC\Controller\ApiController;
use SPC\DTO\StreamData;
use SPC\Service\EpgBuilder;
use SPC\Service\NowPlayingService;
use SPC\Trait\APICacheTrait;


class ScheduleController extends ApiController
{
	protected const string RADIOUAS_URI = 'https://radio.uas.edu.mx';

	use APICacheTrait;

	public function now(): Response
	{
		$streamData = new NowPlayingService()->get();

		if ($this->request->getQuery('format') === 'json') {
			return $this->render()
				->withHeader('Access-Control-Allow-Origin', self::RADIOUAS_URI)
				->withType('application/json')
				->withStringBody(json_encode($streamData));
		}

		$plainText = $streamData->produccion . ' - ' . $streamData->programa;

		$this->viewBuilder()->setLayout(null);

		return $this->render()
			->withHeader('Access-Control-Allow-Origin', self::RADIOUAS_URI)
			->withType('text/plain')
			->withStringBody($plainText);
	}

	public function daily(): Response
	{
		$day = $this->getRequestedDay();

		$isMobileApp = ($this->request->getQuery('source')) !== null && $this->request->getQuery('source') == 'mobile-app';

		$fields = $isMobileApp ? [
				'ID', 'name', 'horaInicio', 'horaFin', 'image', 'categoryID',
				'subtitle' => 'produccion',
				'music' => 'musical',
				'startTime' => 'horaInicio',
				'endTime' => 'horaFin',
			] : [
				'name', 'horaInicio', 'horaFin', 'image', 'produccion',
				'icon' => 'uo',
				'music' => 'musical',
				'starts' => 'horaInicio',
				'ends' => 'horaFin',
			];

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

			if ($isMobileApp) {
				$entry['startTime'] = $programa->horaInicio;
				$entry['endTime'] = $programa->horaFin;
			} else {
				$entry['starts'] = $programa->horaInicio;
				$entry['ends'] = $programa->horaFin;
			}
			$result[] = $entry;
		}

		if ($this->isOverrideActive()) {
			$result = $this->spliceOverride($this->getActiveOverride(), $result, $isMobileApp);
		}

		return $this->response
			->withHeader('Access-Control-Allow-Origin', self::RADIOUAS_URI)
			->withType('application/json')
			->withStringBody(json_encode($result));
	}

	private function spliceOverride(StreamData $override, array $entries, bool $isMobileApp): array
	{
		$startKey = $isMobileApp ? 'startTime' : 'starts';
		$endKey = $isMobileApp ? 'endTime' : 'ends';

		$overrideStart = $override->horaInicio;
		$overrideEnd = $overrideStart->addMinutes($override->durationMinutes);

		$merged = [];
		foreach ($entries as $entry) {
			/** @var Time $start */
			$start = $entry[$startKey];
			/** @var Time $end */
			$end = $entry[$endKey];
			if ($end <= $start) {
				$end = $end->addDays(1);
			}

			if ($end <= $overrideStart || $start >= $overrideEnd) {
				$merged[] = $entry;
				continue;
			}
			if ($start < $overrideStart) {
				$entry[$endKey] = $overrideStart;
				$merged[] = $entry;
				continue;
			}
			if ($end > $overrideEnd) {
				$entry[$startKey] = $overrideEnd;
				$merged[] = $entry;
			}
		}

		$overrideEntry = $this->buildOverrideEntry($override, $isMobileApp, $overrideStart, $overrideEnd);

		$index = null;
		foreach ($merged as $i => $entry) {
			if ($entry[$startKey] >= $overrideEnd) {
				$index = $i;
				break;
			}
		}

		if ($index === null) {
			$merged[] = $overrideEntry;
		} else {
			array_splice($merged, $index, 0, [$overrideEntry]);
		}

		if (! $isMobileApp) {
			foreach ($merged as &$entry) {
				$entry['starts'] = $entry['starts']->i18nFormat('h:mm a', 'en-US');
				$entry['ends'] = $entry['ends']->i18nFormat('h:mm a', 'en-US');
			}
			unset($entry);
		}

		return $merged;
	}

	private function buildOverrideEntry(StreamData $override, bool $isMobileApp, Time $start, Time $end): array
	{
		$entry = [
			'name' => $override->programa,
			'image' => $override->image,
			'music' => $override->music,
		];

		if ($isMobileApp) {
			$entry['subtitle'] = $override->produccion;
			$entry['categoryID'] = null;
			$entry['startTime'] = $start;
			$entry['endTime'] = $end;
		} else {
			$entry['produccion'] = $override->produccion;
			$entry['icon'] = null;
			$entry['starts'] = $start;
			$entry['ends'] = $end;
		}

		return $entry;
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