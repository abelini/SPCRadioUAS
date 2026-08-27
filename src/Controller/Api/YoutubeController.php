<?php
declare(strict_types=1);

namespace SPC\Controller\Api;

use SPC\Controller\ApiController;
use Cake\Core\Configure;
use Cake\Http\Client\Exception\NetworkException;
use Cake\Http\Client;
use Cake\Http\Response;
use Cake\Cache\Cache;
use Cake\Http\Exception\NotFoundException;

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
		$this->YoutubeAPIKey = Configure::read('SensitiveData.YouTube.APIKey');
	}

	public function playlist(): Response
	{
		$playlistID = $this->request->getQuery('list');

		if (!$playlistID) {
			throw new NotFoundException(__('Identificador de lista no proporcionado.'));
		}

		$cacheKeyMeta = 'yt_playlist_meta_' . $playlistID;
		$cacheKeyItems = 'yt_playlist_items_' . $playlistID;

		$cachedMeta = Cache::read($cacheKeyMeta, 'yt_rest_calls');
		$cachedItems = Cache::read($cacheKeyItems, 'yt_rest_calls');

		$playlistTitle = $cachedMeta['title'] ?? '';
		$playlistItems = $cachedItems['items'] ?? [];

		try {
			$youtube = new Client(self::YOUTUBE_API_CONFIG);

			// 1. Obtener Metadatos (Título y ETag de la playlist)
			$metaHeaders = [];
			if (!empty($cachedMeta['etag'])) {
				$metaHeaders['If-None-Match'] = $cachedMeta['etag'];
			}

			$metaResponse = $youtube->get('/playlists', [
				'id' => $playlistID,
				'part' => 'snippet',
				'key' => $this->YoutubeAPIKey,
			], ['headers' => $metaHeaders]);

			if ($metaResponse->isOk()) {
				$metaJson = json_decode($metaResponse->getStringBody());
				if (!empty($metaJson->items)) {
					$playlistTitle = $metaJson->items[0]->snippet->title;
					Cache::write($cacheKeyMeta, [
						'title' => $playlistTitle,
						'etag' => $metaJson->etag ?? '',
					], 'yt_rest_calls');
				}
			}

			// 2. Obtener los Videos (Items de la playlist)
			$itemsHeaders = [];
			if (!empty($cachedItems['etag'])) {
				$itemsHeaders['If-None-Match'] = $cachedItems['etag'];
			}

			$itemsResponse = $youtube->get('/playlistItems', [
				'playlistId' => $playlistID,
				'part' => 'snippet',
				'maxResults' => 20,
				'key' => $this->YoutubeAPIKey,
			], ['headers' => $itemsHeaders]);

			if ($itemsResponse->isOk()) {
				$itemsJson = json_decode($itemsResponse->getStringBody());
				$playlistItems = $itemsJson->items ?? [];

				Cache::write($cacheKeyItems, [
					'items' => $playlistItems,
					'etag' => $itemsJson->etag ?? '',
				], 'yt_rest_calls');
			}

		} catch (NetworkException $e) {
			$this->Flash->error('Error de conexión a la API de YouTube: ' . $e->getMessage());
		}

		$this->set(compact('playlistItems', 'playlistTitle'));
		$this->viewBuilder()->setLayout('youtube');

		return $this->render();
	}

	/*
	public function playlist(): Response
	{
		$playlistID = $this->request->getQuery('list');
		try {
			$youtube = new Client(self::YOUTUBE_API_CONFIG);
			$playlist = $youtube->get('/playlistItems', [
				'playlistId' => $playlistID,
				'part' => 'snippet',
				'maxResults' => 20,
				'key' => $this->YoutubeAPIKey
			]);
			$playlist = json_decode($playlist->getStringBody());
			debug($playlist);
			$playlistItems = $playlist->items;
		} catch (NetworkException $e) {
			$this->Flash->error('Error de conexión a la API de YouTube: ' . $e->getMessage());
			$playlistItems = [];
		}
		$this->set('playlistItems', $playlistItems);
		$this->viewBuilder()->setLayout('youtube');

		return $this->render();
	}
	*/
}
