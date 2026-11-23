<?php

declare(strict_types=1);

namespace SPC\Controller\Api;

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Http\Client;
use Cake\Http\Response;
use Cake\I18n\DateTime;
use Cake\I18n\Time;
use Cake\ORM\Query\SelectQuery;
use SPC\Controller\ApiController;
use SPC\DTO\FBComment;
use SPC\Model\Entity\Programa;
use SPC\Service\GeminiService;
use SPC\Service\SocialContentService;
use SPC\Trait\APICacheTrait;

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
		$nombrePrograma = (string)urldecode((string)$this->request->getQuery('name'));

		$programa = $this->getTableLocator()->get('Programas')
			->find()
			->where(['name' => $nombrePrograma])
			->contain('TemasProgramas', fn(SelectQuery $query) => $query->select(['ID', 'ProgramaID', 'tema', 'invitados', 'tags']))
			->first();

		if ($programa) {
			$programa->set('image', $programa->image_url);
		}

		return $this->response
			->withType('application/json')
			->withStringBody(json_encode(['programa' => $programa]));
	}

	public function generateSocialContent(): Response
	{
		$type = $this->request->getData('type') ?? self::LIVE_SHOW;
		$prompt = Configure::read('Prompts.' . $type);

		if ($type == self::LIVE_SHOW) {
			$nombrePrograma = trim(strip_tags((string)$this->request->getData('programa')));
			$nuevaConduccion = trim(strip_tags((string)$this->request->getData('conduccion')));
			$nuevoInvitados = trim(strip_tags((string)$this->request->getData('invitados')));
			$nuevoTema = trim(strip_tags((string)$this->request->getData('tema')));
			$nuevosTags = trim(strip_tags((string)$this->request->getData('tags')));

			$programasTable = $this->getTableLocator()->get('Programas');
			$programa = $programasTable
				->find()
				->select(['ID', 'name', 'conduccion'])
				->where(['name' => $nombrePrograma])
				->contain('TemasProgramas', fn(SelectQuery $query) => $query->select(['ID', 'ProgramaID', 'tema', 'invitados', 'tags']))
				->first();

			if ($programa instanceof Programa) {
				// Actualizar conduccion en Programas
				$programa->set('conduccion', $nuevaConduccion);
				$programasTable->save($programa);

				// Actualizar o crear en TemasProgramas
				$temasTable = $this->getTableLocator()->get('TemasProgramas');
				$tema = $programa->get('tema');
				if (!isset($tema)) {
					$tema = $temasTable->newEmptyEntity();
					$tema->set('programaID', $programa->get('ID'));
				}
				$tema->set('tema', $nuevoTema);
				$tema->set('invitados', $nuevoInvitados);
				$tema->set('tags', $nuevosTags);
				$temasTable->save($tema);
			}

			$socialService = new SocialContentService();
			$respuesta = $socialService->generateForProgramName($nombrePrograma);
		} else {
			$evento = $this->request->getData('evento');
			$participantes = $this->request->getData('participantes') ? 'Los participantes son: «' . $this->request->getData('participantes') . '».' : '';

			$prompt = str_replace(['%evento%', '%participantes%'], [$evento, $participantes], (string)Configure::read('Prompts.' . $type));

			$controlActual = Cache::read(self::CR_CACHE_KEY, self::CR_CACHE_CONFIG);

			if (!$controlActual || $controlActual['evento'] !== $evento) {
				Cache::write(self::CR_CACHE_KEY, [
					'evento' => $evento,
					'produccion' => 'Transmisión remota',
					'inicio' => DateTime::now()->getTimestamp()
				], self::CR_CACHE_CONFIG);
			}

			$gemini = new GeminiService();
			$respuesta = $gemini->generateText($prompt);
		}

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
		$accessTokens = Configure::read('SensitiveData.Facebook.Tokens.User');

		if ($this->isNowBroadcasting()) {

			$http = new Client([
				'scheme' => 'https',
				'host' => 'graph.facebook.com',
				'basePath' => Configure::read('SensitiveData.Facebook.APIv'),
			]);
			$liveVideos = Configure::read('SensitiveData.Facebook.RadioUASAppID') . '/live_videos';

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

					$response = $http->get($videoID . '/comments', [
						'fields' => 'from,message,parent,created_time',
						'access_token' => Configure::read('SensitiveData.Facebook.Tokens.Page'),
					]);
					$body = json_decode($response->getStringBody());

					if (isset($body->data)) {
						$comments = array_reverse($body->data);
					} else {
						$comments = [
							new FBComment()
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
