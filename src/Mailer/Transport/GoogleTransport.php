<?php

namespace App\Mailer\Transport;

use Cake\Mailer\AbstractTransport;
use Cake\Mailer\Message;


class GoogleTransport extends AbstractTransport {
	
	protected const array CONFIG = [
		'host' => 'smtp.gmail.com',
		'port' => 587,
		'username' => 'radio@uas.edu.mx',
		'password' => 'sfzvholhfjccuqaz',
		'className' => 'Smtp',
		'tls' => true,
	];
	
	
	public function __construct() {
		$this->setConfig(self::CONFIG);
	}
	
	public function send(Message $message): array {
		//return parent::send($message); <-- send() es un método abstracto, no tiene implementación en la clase padre
		return [];
	}
}