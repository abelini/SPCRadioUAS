<?php
declare(strict_types=1);

namespace SPC\Controller\Api;

use SPC\Controller\ApiController;
use Cake\Http\Client;
use Cake\Http\Response;

class YoutubeController extends ApiController
{

	private const string YOUTUBE_API_KEY = 'AIzaSyA40S5sRQTcNuse6go5AMrZN9BXsIuf70Q';

	private const array YOUTUBE_API_CONFIG = [
		'scheme' => 'https',
		'host' => 'www.googleapis.com',
		'basePath' => 'youtube/v3',
	];

	public function playlist(): Response
	{
		$playlistID = $this->request->getQuery('list');
		try {
			$youtube = new Client(self::YOUTUBE_API_CONFIG);
			$playlist = $youtube->get('/playlistItems', ['playlistId' => $playlistID, 'part' => 'snippet', 'maxResults' => 20, 'key' => self::YOUTUBE_API_KEY]);
			$playlist = json_decode($playlist->getStringBody());
			$playlistItems = $playlist->items;
		} catch (NetworkException $e) {
			$template = 'widget_error';
			$this->Flash->error('Error de conexión a la API de YouTube: ' . $e->getMessage());
			$playlistItems = [];
		}
		$this->set('playlistItems', $playlistItems);
		$this->viewBuilder()->setLayout('youtube');

		return $this->render();
	}
}
