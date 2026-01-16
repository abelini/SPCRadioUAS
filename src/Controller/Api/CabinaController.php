<?php
declare(strict_types=1);

namespace SPC\Controller\Api;

use SPC\Controller\ApiController;
use Cake\Core\Configure;
use Cake\Http\Client;
use Cake\Http\Response;
use Cake\I18n\DateTime;
use Cake\I18n\Time;
use Cake\ORM\Query\SelectQuery;
use ScheduleController;
use SPC\Model\Entity\DefaultComment;
use SPC\Service\GeminiService;


class CabinaController extends ApiController
{

	private const string FB_GRAPH_API_HOST = 'https://graph.facebook.com';

	private const string FB_GRAPH_API_VERSION = 'v21.0';

	private const int FB_RADIOUAS_ID = 181192951922545;

	private const string ACCESS_TOKEN = 'EAAD9svI5jeEBOZCzgLEJqJXz1HJ0R5jQagDu7dAzdKDhmZA5xa7exLG36Jy3uefUI3PIGa1LPgCuc61TQ9ph8twO2ZAqQVZCeRrtX6UCnn31QT0fTzV0ydbywG6XafES6FyjyICbUDtZCKWRkKgfBX078V3HM3w6RVIIJIWZBROkY6fZCPCBevgFTdZAmA8USjEhyVh41YRt';

	private const array ACCESS_TOKENS = [

		// Abel Botello
		'EAAD9svI5jeEBOZCzgLEJqJXz1HJ0R5jQagDu7dAzdKDhmZA5xa7exLG36Jy3uefUI3PIGa1LPgCuc61TQ9ph8twO2ZAqQVZCeRrtX6UCnn31QT0fTzV0ydbywG6XafES6FyjyICbUDtZCKWRkKgfBX078V3HM3w6RVIIJIWZBROkY6fZCPCBevgFTdZAmA8USjEhyVh41YRt',

		// Carlos Rangel
		'EAAD9svI5jeEBO1HrAhXrZCyjlbsdFFtOgwQDlOCwZB76iEhTcQol48xzgiUbebmdFZCZCQttg6fJmSd3HWhNzuIZCgqHsiTMuJA7TPdtpshpPkQbBKPdktif2jMMYwFw5CfP4TkVT2pM5AnsvmI9jahlTMlD2SXEwrYo79MZBYmICdhSwxIswSJlKpcPGRrGIZD',

		// Alethia Perez
		// Tania
		'EAAD9svI5jeEBO1lKrMJbkTIj0MVchBqnAtdDZBptZCK1naoDEvz9VX9Rd2ZCb8Oyum0YiU6mdWTLu3CdfLhSO3XZBx1CUPAZCQmyrhAKydhbNkPEGIKPAPpCSDu8j6a5oRmaGu7kPZBuysoPav7dRTLImvSZBZCdQ60QrIlxj440qQOpfOrmdESjyRtEOTIq',
	];

	public function comments(): Response
	{
		$this->viewBuilder()->setLayout('live_stream');
		return $this->render();
	}

	public function social(): Response
	{
		if (!$this->request->is('ajax')) {
			// return $this->redirect(['action' => 'index']);
		}

		$this->viewBuilder()->setLayout('ajax');

		$tipo = $this->request->getQuery('type');

		switch ($tipo) {
			case 'live_show':
				return $this->_liveShowForm();

			case 'live_broadcast':
				return $this->_liveBroadcastForm();

			default:
				$this->set('mensaje', 'Contenido no encontrado');
				return $this->render('error_ajax');
		}
	}
	protected function _liveShowForm(): Response
	{
		$programas = $this->getTableLocator()
			->get('Programas')
			->find()
			//->select(['Programas.ID', 'Programas.name', 'Programas.produccion'])
			->where([
				'Programas.reportable' => true,
			])
			->matching('Dias', function (SelectQuery $query) {
				return $query->where(['Dias.ID' => (new DateTime())->dayOfWeek]);
			})
			->contain(['TemasProgramas'])
			->orderByAsc('horaInicio')
			->all();

		$nextPrograms = $programas->filter(function ($programa, $key) {
			$now = Time::now();
			return ($programa->horaInicio >= $now);
		});
		//debug($nextPrograms->first());
		$this->set('programas', $programas);
		$this->set('nextProgram', $nextPrograms->first());
		return $this->render('live_show');
	}

	protected function _liveBroadcastForm(): Response
	{
		$fecha = date('Y-m-d');
		$this->set('fechaActual', $fecha);

		return $this->render('live_broadcast');
	}

	public function getProgramInfo()
	{
		$this->request->allowMethod(['ajax', 'get']);
		$nombrePrograma = $this->request->getQuery('name');

		$programa = $this->getTableLocator()->get('Programas')
			->find()
			->where(['name' => $nombrePrograma])
			->contain('TemasProgramas')
			->first();

		return $this->response
			->withType('application/json')
			->withStringBody(json_encode(['programa' => $programa]));
	}

	public function generateSocialContent(): Response
	{
		$type = $this->request->getData('type');
		$prompt = Configure::read('Prompts.' . $type);

		if ($type == 'liveShow') {
			$programa = $this->request->getData('programa');
			$tema = $this->request->getData('tema') ? 'El tema a abordar es: «' . $this->request->getData('tema') . '».' : '';
			$conduccion = $this->request->getData('conduccion') ? $this->request->getData('conduccion') : '';
			$invitados = $this->request->getData('invitados') ? 'El|La|Los invitado(s) es|son: ' . $this->request->getData('invitados') . '.' : '';

			$prompt = str_replace(['%programa%', '%conduccion%', '%invitados%', '%tema%'], [$programa, $conduccion, $invitados, $tema], $prompt);
		} else {
			$evento = $this->request->getData('evento');
			$participantes = $this->request->getData('participantes') ? 'Los participantes son: «' . $this->request->getData('participantes') . '».' : '';

			$prompt = str_replace(['%evento%', '%participantes%'], [$evento, $participantes], $prompt);
		}

		$respuesta = $prompt;
		$gemini = new GeminiService();
		$respuesta = $gemini->generateText($prompt);

		$this->set(compact('respuesta'));
		$this->viewBuilder()->setLayout('ajax');

		return $this->render('social_content');
	}

	public function isNowBroadcasting(): bool
	{
		$today = DateTime::now();
		$programas = $this->getTableLocator()
			->get('Programas')
			->find()
			->matching('Dias', function (SelectQuery $query) {
				return $query->where(['Dias.ID' => (new DateTime())->dayOfWeek]);
			})
			->orderAsc('horaInicio')
			->all();

		$programa = $programas->filter(function ($programa, $key) {
			$now = Time::now();
			return ($programa->horaInicio <= $now && $programa->horaFin >= $now);
		});

		return $programa->count() > 0;
	}

	public function getComments(): Response
	{
		$comments = [];
		$legend = 'No hay transmisiones en curso';

		if ($this->isNowBroadcasting()) {

			$http = new Client();
			$endpoint = self::FB_GRAPH_API_HOST . DS . self::FB_GRAPH_API_VERSION . DS;

			$query = 'live_videos?broadcast_status[]=LIVE&access_token=';

			for ($i = 0; $i < count(self::ACCESS_TOKENS); $i++) {

				$response = $http->get($endpoint . self::FB_RADIOUAS_ID . DS . $query . self::ACCESS_TOKENS[$i]);
				$body = json_decode($response->getStringBody());

				if (isset($body->data) && !empty($body->data)) {
					$embed = $body->data[0]->embed_html;
					$videoID = $body->data[0]->id;
					$title = $body->data[0]->title;

					$query = '?fields=comments{from,message,parent,created_time}&access_token=';
					$response = $http->get($endpoint . $videoID . DS . $query . self::ACCESS_TOKENS[$i]);

					$body = json_decode($response->getStringBody());

					if (isset($body->comments->data)) {
						$comments = array_reverse($body->comments->data);

					} else {
						$comments = [
							new DefaultComment()
						];
					}
					$legend = 'Comentarios en:<br><strong>' . $title . '</strong>';
					break;

				} else if (isset($body->error)) {
					$legend = '[#ApplicationRequestLimitReached]';
					continue;
				} else {
					$legend .= ' [#ScheduledTimeButNoStream]';
					break;
				}
			}
		} else {
			$legend .= ' [#NoBroadcastingTime]';
		}

		$this->set(compact('comments', 'legend'));
		$this->viewBuilder()->setLayout('ajax');

		return $this->render();
	}
}
