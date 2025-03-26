<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\Http\Client;
use Cake\ORM\Entity;


class Worker extends Entity implements \Stringable {

	protected array $_hidden = [
		'password',
	];
	
	/**
	 * REST API
	 *
	 * Method to get the profile picture set in RADIO.UAS.EDU.MX
	 * using the Wordpress Rest API
	 */
	public function getProfilePicture() : string { //debug('/members?search='.urlencode($this->name)); return '';/*
		$http = new Client([
		    'host' => 'radio.uas.edu.mx',
		    'scheme' => 'https',
		    'basePath' => 'wp-json/wp/v2',
		]);
		$request = $http->get('/members?search='.urlencode($this->name));
		$response = json_decode($request->getStringBody());
		
		$mediaID = $response[0]->featured_media;
		
		$request = $http->get('/media/'. $mediaID);
		$response = $request->getJson();
		
		$photo = $response['media_details']['sizes']['qantumthemes-thumb-squared']['source_url'];

		return $photo ?? '';
	}
    
    	public function __toString() : string {
		return $this->name;
	}
}
