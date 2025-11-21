<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Client;
use Cake\Http\Client\Exception\NetworkException;
use Cake\Http\Request;
use Cake\Http\Response;


class MusicController extends AppController {
	
	private const string API_KEY = '2800fcd5956c46dfb55dd2686a96e6e7';
	
	private const array REQUEST_CONFIG = [
		'scheme' => 'https',
		'host' => 'emby.radiouas.org',
		'port' => 8920,
		'basePath' => 'emby',
		'headers' => [
			'X-Emby-Token' => self::API_KEY,
		],
	];
	
	public function initialize() : void {
		parent::initialize();
		$this->Authentication->allowUnauthenticated(['album', 'artist', 'playlist']);
	}
	
	public function album() : Response {
		$index = 1;
		$albumID = $this->request->getQuery('ID');
		$tracklist = boolval($this->request->getQuery('hide_tracklist'));
		
		$http = new Client(self::REQUEST_CONFIG);
		try {
			$response = $http->get('/Items',
									['ParentId' => $albumID, 'IncludeItemTypes' => 'Audio', 'Recursive' => 'true']);

			$playlist = json_decode($response->getStringBody());
			
			$cover = $http->buildURL('/Items/'.$albumID.'/Images/Primary', ['api_key' => self::API_KEY], $http->getConfig());
			
			$response = $http->get('/Items', ['Ids' => $albumID]);

			$albumInfo = json_decode($response->getStringBody());

			
			$this->set(compact('http', 'playlist', 'albumInfo', 'cover', 'index'));
			$this->set('api_key', self::API_KEY);
			$this->set('bgColor', $this->request->getQuery('bgColor'));
			$this->set('txtColor', $this->request->getQuery('txtColor'));
			
			$this->viewBuilder()->setLayout('widget');
			$template = ($tracklist)? 'album_no_tracklist' : 'album';
		}
		catch(NetworkException $e){
			$template = 'widget_error';
			$this->Flash->error('Error de conexión a la Fonoteca: '.$e->getMessage());
		}
		
		return $this->render($template);
	}
	
	public function artist() : Response {
		$index = 1;
		$albumID = $this->request->getQuery('ID');
		$http = new Client(self::REQUEST_CONFIG);

		$response = $http->get('/Items',
								['ParentId' => $albumID, 'IncludeItemTypes' => 'Audio', 'Recursive' => 'true']);

		$playlist = json_decode($response->getStringBody());
		
		$cover = $http->buildURL('/Items/'.$albumID.'/Images/Primary',
								['api_key' => self::API_KEY], $http->getConfig());
		
		$this->set(compact('http', 'playlist', 'cover', 'index'));
		$this->set('api_key', self::API_KEY);
		
		$this->viewBuilder()->setLayout('widget');
		
		return $this->render();
	}
	
	public function playlist() : Response {
		$index = 1;
		$playlistID = $this->request->getQuery('ID');
		$http = new Client(self::REQUEST_CONFIG);

		$response = $http->get('/Playlists/'.$playlistID.'/Items',
								['Limit' => 20]);

		$playlist = json_decode($response->getStringBody());
		
		$cover = $http->get('/Items/'. $albumID .'/Images/Primary');
		
		$this->set(compact('http', 'playlist', 'cover', 'index'));
		$this->set('api_key', self::API_KEY);
		
		$this->viewBuilder()->setLayout('widget');
		
		return $this->render();
	}
	
	
}