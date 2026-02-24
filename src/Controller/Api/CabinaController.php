<?php
declare(strict_types=1);

namespace SPC\Controller\Api;

use SPC\Controller\ApiController;
use SPC\Trait\APICacheTrait;
use Cake\Cache\Cache;
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
	use APICacheTrait;

	public function comments(): Response
	{
		$this->viewBuilder()->setLayout('live_stream');
		return $this->render();
	}

	public function social(): Response
	{
		$this->viewBuilder()->setLayout('ajax');

		$tipo = $this->request->getQuery('type') ?? self::LIVE_SHOW;

		switch ($tipo) {
			case self::LIVE_SHOW:
				return $this->_liveShowForm();

			case self::LIVE_BROADCAST:
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
				'Programas.outOfAir' => false,
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

		return $this->render(self::LIVE_SHOW);
	}

	protected function _liveBroadcastForm(): Response
	{
		$fecha = date('Y-m-d');
		$this->set('fechaActual', $fecha);

		return $this->render(self::LIVE_BROADCAST);
	}

	public function getProgramInfo(): Response
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
		$type = $this->request->getData('type') ?? self::LIVE_SHOW;
		debug($type);
		$prompt = Configure::read('Prompts.' . $type);

		if ($type == self::LIVE_SHOW) {
			$programa = $this->getTableLocator()->get('Programas')
				->find()
				->select(['ID', 'name', 'conduccion'])
				->where(['name' => $this->request->getData('programa')])
				->contain('TemasProgramas', function (SelectQuery $query) {
					return $query->select(['ID', 'ProgramaID', 'invitados', 'tags']);
				})
				->first();

			$conduccion = 'Conductor/a: ' . $programa->conduccion;
			$invitados = $this->request->getData('invitados') ? 'Invitado(s): ' . $this->request->getData('invitados') : 'Invitado(s): ' . $programa->tema->invitados;
			$keywords = $programa->tema->tags ? 'Palabras clave/Estilo: ' . $programa->tema->tags : '';
			$tema = $this->request->getData('tema') ? 'Tema del día: ' . $this->request->getData('tema') : 'Tema del día: ' . $programa->tema->tema;
			$programa = 'Programa: ' . $programa->name;

			$prompt = str_replace(['%programa%', '%conduccion%', '%invitados%', '%tema%', '%keywords%'], [$programa, $conduccion, $invitados, $tema, $keywords], $prompt);
		} else {
			$evento = $this->request->getData('evento');
			$participantes = $this->request->getData('participantes') ? 'Los participantes son: «' . $this->request->getData('participantes') . '».' : '';

			$prompt = str_replace(['%evento%', '%participantes%'], [$evento, $participantes], $prompt);

			$controlActual = Cache::read(self::CONTROL_REMOTO_CACHE);

			if (!$controlActual || $controlActual['evento'] !== $evento) {
				Cache::write(self::CONTROL_REMOTO_CACHE, [
					'evento' => $evento,
					'produccion' => 'Transmisión remota',
					'inicio' => DateTime::now()->getTimestamp()
				]);
			}
		}

		//$respuesta = $prompt;
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
			->where([
				'reportable' => true,
				'outOfAir' => false,
			])
			->matching('Dias', function (SelectQuery $query) {
				return $query->where(['Dias.ID' => (new DateTime())->dayOfWeek]);
			})
			->orderByAsc('horaInicio')
			->all();

		$programa = $programas->filter(function ($programa, $key) {
			$now = Time::now();
			return $now->between($programa->horaInicio, $programa->horaFin);
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
			$liveVideos = Configure::read('SensitiveData.Facebook.RadioUASAppID') . '/live_videos';

			$accessTokens = Configure::read('SensitiveData.Facebook.AccessTokens');

			for ($i = 0; $i < count($accessTokens); $i++) {
				$response = $http->get($liveVideos, [
					'broadcast_status[]' => 'LIVE',
					'access_token' => $accessTokens[$i],
				]);
				$body = json_decode($response->getStringBody());

				if (isset($body->data) && !empty($body->data)) {
					$embed = $body->data[0]->embed_html;
					$videoID = $body->data[0]->id;
					$title = $body->data[0]->title;

					$response = $http->get($videoID, [
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
