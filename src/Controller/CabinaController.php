<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Client;
use Cake\Http\Response;
use Cake\I18n\DateTime;
use Cake\I18n\Time;
use Cake\ORM\Query\SelectQuery;
use ScheduleController;
use App\Model\Entity\DefaultComment;


class CabinaController extends AppController {
	
	private const string FB_GRAPH_API_HOST = 'https://graph.facebook.com';
	
	private const string FB_GRAPH_API_VERSION = 'v21.0';
	
	private const int FB_RADIOUAS_ID = 181192951922545;
	
	private const string ACCESS_TOKEN = 'EAAD9svI5jeEBOZCzgLEJqJXz1HJ0R5jQagDu7dAzdKDhmZA5xa7exLG36Jy3uefUI3PIGa1LPgCuc61TQ9ph8twO2ZAqQVZCeRrtX6UCnn31QT0fTzV0ydbywG6XafES6FyjyICbUDtZCKWRkKgfBX078V3HM3w6RVIIJIWZBROkY6fZCPCBevgFTdZAmA8USjEhyVh41YRt';
	
	private const array ACCESS_TOKENS = [
		
		// Carlos Rangel
			'EAAD9svI5jeEBO1HrAhXrZCyjlbsdFFtOgwQDlOCwZB76iEhTcQol48xzgiUbebmdFZCZCQttg6fJmSd3HWhNzuIZCgqHsiTMuJA7TPdtpshpPkQbBKPdktif2jMMYwFw5CfP4TkVT2pM5AnsvmI9jahlTMlD2SXEwrYo79MZBYmICdhSwxIswSJlKpcPGRrGIZD',
		
		// Abel Botello
			'EAAD9svI5jeEBOZCzgLEJqJXz1HJ0R5jQagDu7dAzdKDhmZA5xa7exLG36Jy3uefUI3PIGa1LPgCuc61TQ9ph8twO2ZAqQVZCeRrtX6UCnn31QT0fTzV0ydbywG6XafES6FyjyICbUDtZCKWRkKgfBX078V3HM3w6RVIIJIWZBROkY6fZCPCBevgFTdZAmA8USjEhyVh41YRt',
		
		// Alethia Perez
		// Tania
			'EAAD9svI5jeEBO1lKrMJbkTIj0MVchBqnAtdDZBptZCK1naoDEvz9VX9Rd2ZCb8Oyum0YiU6mdWTLu3CdfLhSO3XZBx1CUPAZCQmyrhAKydhbNkPEGIKPAPpCSDu8j6a5oRmaGu7kPZBuysoPav7dRTLImvSZBZCdQ60QrIlxj440qQOpfOrmdESjyRtEOTIq',
		
	];
	

	public function initialize() : void {
		parent::initialize();
		$this->Authentication->allowUnauthenticated(['comments', 'getComments']);
	}
	
	public function comments() : Response {
		$this->viewBuilder()->setLayout('live_stream');
		return $this->render();
	}
	
	public function isNowBroadcasting() : bool {
		$today = DateTime::now();
		$programas = $this->getTableLocator()
							->get('Programas')
								->find()
									->matching('Dias', function(SelectQuery $query) {
										return $query->where(['Dias.ID' => (new DateTime())->dayOfWeek]);
									})
									->orderAsc('horaInicio')
									->all();
									
		$programa = $programas->filter(function($programa, $key) {
			$now = Time::now(); 
			return ($programa->horaInicio <= $now && $programa->horaFin >= $now);
		});
		
		return $programa->count() > 0;
	}
	
	public function getComments() : Response {
		$comments = [];
		$legend = 'No hay transmisiones en curso';
		
		if($this->isNowBroadcasting()) {
		
			$http = new Client();
			$endpoint = self::FB_GRAPH_API_HOST . DS . self::FB_GRAPH_API_VERSION . DS;
			
			$query = 'live_videos?broadcast_status[]=LIVE&access_token=';
			
			for($i = 0; $i < count(self::ACCESS_TOKENS); $i++) {
				
				$response = $http->get($endpoint . self::FB_RADIOUAS_ID . DS . $query . self::ACCESS_TOKENS[$i]);
				$body = json_decode($response->getStringBody());
				
				if(isset($body->data) && !empty($body->data)) {
					$embed = $body->data[0]->embed_html;
					$videoID = $body->data[0]->id;
					$title = $body->data[0]->title;
				
					$query = '?fields=comments{from,message,parent,created_time}&access_token=';
					$response = $http->get($endpoint . $videoID . DS . $query . self::ACCESS_TOKENS[$i]);
					
					$body = json_decode($response->getStringBody());
					
					if(isset($body->comments->data)) {
						$comments = array_reverse($body->comments->data);
						
					}
					else {
						$comments = [
							new DefaultComment()
						];
					}
					$legend = 'Comentarios en:<br><strong>'.$title.'</strong>';
					break;
					
				}
				else if(isset($body->error)) {
					$legend = '[#ApplicationRequestLimitReached]';
					continue;
				}
				else {
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