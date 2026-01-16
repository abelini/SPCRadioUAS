<?php
declare(strict_types=1);

namespace SPC\Controller\Api;

use SPC\Controller\ApiController;
use Cake\Core\Configure;
use Cake\Http\Client;
use Cake\Http\Client\Exception\NetworkException;
use Cake\Http\Response;


class MusicController extends ApiController
{

	private string $EmbyAPIKey;

	private array $EmbyConfig;

	private int $maxDisplayedSongs = 15;

	public function initialize(): void
	{
		parent::initialize();
		$this->EmbyAPIKey = Configure::read('SensitiveData.Emby.APIKey');
		$this->EmbyConfig = [
			'scheme' => 'https',
			'host' => 'emby.radiouas.org',
			'port' => 8920,
			'basePath' => 'emby',
			'ssl_verify_peer' => false,
			'ssl_verify_peer_name' => false,
			'ssl_verify_host' => false,
			'headers' => [
				'X-Emby-Token' => $this->EmbyAPIKey,
			],
		];
	}

	public function album(): Response
	{
		$index = 1;
		$albumID = $this->request->getQuery('ID');
		$tracklist = boolval($this->request->getQuery('hide_tracklist'));

		$http = new Client($this->EmbyConfig);
		try {
			$response = $http->get(
				'/Items',
				['ParentId' => $albumID, 'IncludeItemTypes' => 'Audio', 'Recursive' => 'true']
			);

			$playlist = json_decode($response->getStringBody());
			$cover = $http->buildURL('/Items/' . $albumID . '/Images/Primary', ['api_key' => $this->EmbyAPIKey], $http->getConfig());

			$response = $http->get('/Items', ['Ids' => $albumID]);

			$albumInfo = json_decode($response->getStringBody());


			$this->set(compact('http', 'playlist', 'albumInfo', 'cover', 'index'));
			$this->set('api_key', $this->EmbyAPIKey);
			$this->set('bgColor', $this->request->getQuery('bgColor'));
			$this->set('txtColor', $this->request->getQuery('txtColor'));

			$this->viewBuilder()->setLayout('widget');
			$template = ($tracklist) ? 'album_no_tracklist' : 'album';
		} catch (NetworkException $e) {
			$template = 'widget_error';
			$this->Flash->error('Error de conexión a la Fonoteca: ' . $e->getMessage());
		}

		return $this->render($template);
	}

	public function artist(): Response
	{
		$index = 1;
		$artistID = $this->request->getQuery('ID');
		$http = new Client($this->EmbyConfig);

		try {
			$response = $http->get(
				'/Items',
				['ParentId' => $artistID, 'Limit' => $this->maxDisplayedSongs, 'SortBy' => 'Random', 'IncludeItemTypes' => 'Audio', 'Recursive' => 'true']
			);
			$playlist = json_decode($response->getStringBody());
			$cover = $http->buildURL(
				'/Items/' . $artistID . '/Images/Primary',
				['api_key' => $this->EmbyAPIKey],
				$http->getConfig()
			);

			$this->set(compact('http', 'playlist', 'cover', 'index'));
			$this->set('api_key', $this->EmbyAPIKey);
			$template = 'artist';
		} catch (NetworkException $e) {
			$template = 'widget_error';
			$this->Flash->error('Error de conexión a la Fonoteca: ' . $e->getMessage());
		}

		$this->viewBuilder()->setLayout('widget');

		return $this->render($template);
	}

	public function playlist(): Response
	{
		$index = 1;
		$playlistID = $this->request->getQuery('ID');
		$http = new Client($this->EmbyConfig);

		$response = $http->get(
			'/Playlists/' . $playlistID . '/Items',
			['Limit' => 20]
		);

		$playlist = json_decode($response->getStringBody());

		$cover = $http->get('/Items/' . $playlistID . '/Images/Primary');

		$this->set(compact('http', 'playlist', 'cover', 'index'));
		$this->set('api_key', $this->EmbyAPIKey);

		$this->viewBuilder()->setLayout('widget');

		return $this->render();
	}


}
