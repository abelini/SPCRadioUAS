<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Client;
use Cake\Http\Client\Exception\NetworkException;
use Cake\Http\Request;
use Cake\Http\Response;


class ProgramsController extends AppController {
	
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
		$this->Authentication->allowUnauthenticated(['list']);
	}
	
	public function list() : Response {
		$index = 1;
		$programEmbyID = 39343; //$this->request->getQuery('ID');
		$maxTracks = 30;
		$start = 0;
		
		$http = new Client(self::REQUEST_CONFIG);
		try {
			$response = $http->get('/Items',
									['ParentId' => $programEmbyID, 'Limit' => $maxTracks, 'StartIndex' => $start,
										'SortBy' => 'SortName', 'SortOrder' => 'Descending', 'Recursive' => 'true']
								);

			$tracklist = json_decode($response->getStringBody());
			
			//$cover = $http->buildURL('/Items/'.$albumID.'/Images/Primary', ['api_key' => self::API_KEY], $http->getConfig());
			
			//$response = $http->get('/Items', ['Ids' => $albumID]);

			//$albumInfo = json_decode($response->getStringBody());

			
			$this->set(compact('tracklist', 'maxTracks'));
			$this->set('api_key', self::API_KEY);
			//$this->set('bgColor', $this->request->getQuery('bgColor'));
			//$this->set('txtColor', $this->request->getQuery('txtColor'));
			
			$this->viewBuilder()->setLayout('widget');
			//$template = ($tracklist)? 'album_no_tracklist' : 'album';
		}
		catch(NetworkException $e){
			//$template = 'widget_error';
			$this->Flash->error('Error de conexión a la Fonoteca: '.$e->getMessage());
		}
		
		return $this->render();
	}
}