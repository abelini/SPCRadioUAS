<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\Http\Client;
use Cake\Http\Response;
use Cake\I18n\DateTime;
use Cake\I18n\Time;
use Cake\ORM\Query\SelectQuery;


class FonotecaController extends AppController {
	
	protected const string DEFAULT_RADIOFEED_TEXT = 'Fonoteca - Paisajes sonoros';
	
	protected const string RADIOUAS_URI = 'https://radio.uas.edu.mx';
	
	public function initialize() : void {
		parent::initialize();
		$this->Authentication->allowUnauthenticated(['test']);
	}
	
	public function test() {
		$requestParams = [
			'protocolVersion' => '2',
			'scheme' => 'https',
			'host' => 'fonoteca.radiouas.org',
			'port' => 8920,
			'basePath' => 'emby',
			'ssl_verify_peer' => false,
			'ssl_verify_host' => false,
			'headers' => [
				'X-Emby-Token' => '54416f1389784e36862041f024d8f679'
			]
		];
		
		$http = new Client($requestParams);
		$request = $http->get('/Playlists/68205/Items?Limit=2&Random=true');
		$response = json_decode($request->getStringBody());
		//debug(json_decode($request->getStringBody()));
		$images = [];
		$audios = [];
		
		foreach($response->Items as $item) {
			//$request = $http->get('/Items/'. $item->Id .'/Images/Primary?format=jpg');
			//$images[] = base64_encode($request->getStringBody());
			
			//$request = $http->get('/Audio/'.$item->Id.'/stream.mp3');
			//$audios[] = base64_encode($request->getStringBody());
			
			//$request = $http->get('/Audio/'.$item->Id.'/stream.mp3');
			//debug($request->getStringBody());
		}
		
		
		
		
		
		
		//$this->set('images', $images);$this->set('audios', $audios);
		$this->set('rolas', $response->Items);
		//debug($response->getJson());
	}
	
}