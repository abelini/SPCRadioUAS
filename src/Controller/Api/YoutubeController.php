<?php
declare(strict_types=1);

namespace SPC\Controller\Api;

use SPC\Controller\ApiController;
use Cake\Core\Configure;
use Cake\Http\Client\Exception\NetworkException;
use Cake\Http\Client;
use Cake\Http\Response;

class YoutubeController extends ApiController
{
	private string $YoutubeAPIKey;
	private const array YOUTUBE_API_CONFIG = [
		'scheme' => 'https',
		'host' => 'www.googleapis.com',
		'basePath' => 'youtube/v3',
	];

	public function initialize(): void
	{
		parent::initialize();
		$this->YoutubeAPIKey = Configure::read('SensitiveData.Youtube.APIKey');
	}

	public function playlist(): Response
	{
		$playlistID = $this->request->getQuery('list');
		try {
			$youtube = new Client(self::YOUTUBE_API_CONFIG);
			$playlist = $youtube->get('/playlistItems', ['playlistId' => $playlistID, 'part' => 'snippet', 'maxResults' => 20, 'key' => $this->YoutubeAPIKey]);
			$playlist = json_decode($playlist->getStringBody());
			$playlistItems = $playlist->items;
		} catch (NetworkException $e) {
			$this->Flash->error('Error de conexión a la API de YouTube: ' . $e->getMessage());
			$playlistItems = [];
		}
		$this->set('playlistItems', $playlistItems);
		$this->viewBuilder()->setLayout('youtube');

		return $this->render();
	}
}
