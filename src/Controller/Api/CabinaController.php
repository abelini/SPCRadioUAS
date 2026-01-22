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
use SPC\Model\Entity\DefaultComment;
use SPC\Service\GeminiService;


class CabinaController extends ApiController
{
	public function comments(): Response
	{
		$this->viewBuilder()->setLayout('live_stream');
		return $this->render();
	}

	public function social(): Response
	{
		if (!$this->request->is('ajax')) {
			return $this->render('error_ajax');
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

			$http = new Client([
				'scheme' => 'https',
				'host' => 'graph.facebook.com',
				'basePath' => Configure::read('SensitiveData.Facebook.APIv'),
			]);
			$endpoint = Configure::read('SensitiveData.Facebook.RadioUASAppID') . '/live_videos';

			$accessTokens = Configure::read('SensitiveData.Facebook.AccessTokens');

			for ($i = 0; $i < count($accessTokens); $i++) {
				$response = $http->get($endpoint, [
					'broadcast_status[]' => 'LIVE',
					'access_token' => $accessTokens[$i],
				]);
				$body = json_decode($response->getStringBody());

				if (isset($body->data) && !empty($body->data)) {
					$embed = $body->data[0]->embed_html;
					$videoID = $body->data[0]->id;
					$title = $body->data[0]->title;

					$endpoint = $videoID;
					$response = $http->get($endpoint, [
						'fields' => 'comments{from,message,parent,created_time}',
						'access_token' => $accessTokens[$i],
					]);
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
