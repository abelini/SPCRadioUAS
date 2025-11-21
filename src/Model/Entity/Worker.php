<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\Http\Client;
use Cake\ORM\Entity;


class Worker extends Entity implements \Stringable {
	
	private int $profilePictureWidth;
	
	private const string DEFAULT_PROFILE_PICTURE = 'https://www.w3schools.com/w3css/img_avatar3.png';
	
	private const int DEFAULT_PROFILE_PICTURE_WIDTH = 690;
	
	protected array $_hidden = [
		'password',
	];
	
	/**
	 * REST API
	 *
	 * Method to get the profile picture set in RADIO.UAS.EDU.MX
	 * using the Wordpress Rest API
	 */
	public function getProfilePictureUrl() : string {
		$http = new Client([
		    'host' => 'radio.uas.edu.mx',
		    'scheme' => 'https',
		    'basePath' => 'wp-json/wp/v2',
		    'protocolVersion' => '2',
		]);
		$request = $http->get('/members?search='.urlencode($this->name));
		//$request = $http->get('/members', ['search' => urlencode($this->name)]);
		$response = json_decode($request->getStringBody());

		$mediaID = $response[0]->featured_media;
		
		$request = $http->get('/media/'. $mediaID);
		$response = $request->getJson();

		$photo = $response['media_details']['sizes']['qantumthemes-squared']['source_url'];
		$photo = $photo ?? $response['media_details']['sizes']['qantumthemes-thumb-squared']['source_url'];
		$this->profilePictureWidth = $response['media_details']['sizes']['qantumthemes-squared']['width'] ?? self::DEFAULT_PROFILE_PICTURE_WIDTH;
		
		return $photo ?? self::DEFAULT_PROFILE_PICTURE;
	}
    
    public function getProfilePicWidth() : int {
	    return $this->profilePictureWidth;
    }
    
    
    	public function __toString() : string {
		return $this->name;
	}
}
