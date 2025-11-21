<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Client;
use Cake\Http\Request;
use Cake\Http\Response;


class MusicController extends AppController {
	
	private const string API_KEY = '2800fcd5956c46dfb55dd2686a96e6e7';
	
	public function initialize() : void {
		parent::initialize();
		$this->Authentication->allowUnauthenticated(['getAlbum']);
	}
	
	public function getAlbum() : Response {
		$index = 1;
		$albumID = $this->request->getQuery('itemID');
		$http = new Client([
			'scheme' => 'https',
			'host' => 'emby.radiouas.org',
			'port' => 8920,
			'basePath' => 'emby',
			'headers' => [
				'X-Emby-Token' => self::API_KEY,
			],
		]);

		$response = $http->get(
			'/Playlists/'.$albumID.'/Items',
			['Limit' => 30],
		);
		$playlist = json_decode($response->getStringBody());
		
		$cover = $http->get(
			'/Items/'. $playlist->Items[0]->AlbumId .'/Images/Primary',
			['Format' => 'jpg']
		);
		
		$this->set(compact('http', 'playlist', 'cover', 'index'));
		$this->set('api_key', self::API_KEY);
		
		$this->viewBuilder()->setLayout('widget');
		
		return $this->render();
	}
	
}