<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\I18n\DateTime;


class DefaultComment {
	
	public string $created_time;
	
	public string $message;
	
	public DefaultUser $from;
	
	
	public function __construct() {
		$timezone = new \DateTimeZone('America/Hermosillo');
		
		$this->from = new DefaultUser();
		
		$this->created_time = (new DateTime(timezone:$timezone))->i18nFormat("hh:mm:ss aaa");
		
		$this->message = 'No hay comentarios...';
	}
	
}

class DefaultUser {
	
	public $name = 'Auto-response';
	
};