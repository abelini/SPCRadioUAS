<?php
declare(strict_types=1);

namespace SPC\Controller\Api;

use SPC\Controller\ApiController;
use Cake\Event\EventInterface;
use Cake\Http\Response;
use Cake\I18n\DateTime;
use Cake\I18n\Time;
use Cake\ORM\Query\SelectQuery;


class ScheduleController extends ApiController
{

	protected const string DEFAULT_RADIOFEED_TEXT = 'Fonoteca - Paisajes sonoros';

	protected const string RADIOUAS_URI = 'https://radio.uas.edu.mx';

	public function now(): Response
	{
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
			return ($programa->horaInicio <= $now && $programa->horaFin >= $now);
		});

		$feed = ($programa->count() == 0) ? self::DEFAULT_RADIOFEED_TEXT : $programa->first()->produccion . ' - ' . $programa->first()->name;

		$this->viewBuilder()->setLayout(null);

		return $this->render()
			->withHeader('Access-Control-Allow-Origin', self::RADIOUAS_URI)
			->withType('text/plain')
			->withStringBody($feed);
	}


	public function daily(): Response
	{
		$day = $this->getRequestedDay();
		$programas = $this->getTableLocator()
			->get('Programas')
			->find()
			->select([
				'name',
				'horaInicio',
				'horaFin',
				'produccion',
				'icon' => 'uo',
				'music' => 'musical',
				'starts' => 'horaInicio',
				'ends' => 'horaFin',
			])
			->where(['Programas.outOfAir' => false])
			->matching('Dias', function (SelectQuery $query) use ($day) {
				return $query->where(['Dias.ID' => $day]);
			})
			->orderByAsc('horaInicio')
			->all();

		return $this->render()
			->withHeader('Access-Control-Allow-Origin', self::RADIOUAS_URI)
			->withType('application/json')
			->withStringBody(json_encode($programas->toArray()));
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

