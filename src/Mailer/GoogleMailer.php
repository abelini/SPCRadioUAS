<?php

namespace App\Mailer;

use Cake\Mailer\Mailer;
use Cake\Mailer\TransportFactory;


class GoogleMailer extends Mailer {
	
	private const array FROM = [
		'radio@uas.edu.mx' => 'Dirección de Radio UAS'
	];
	
	private const array BCC = [
		'abel@uas.edu.mx' => 'Ing. Abel Bottello',
		'angelloperez@uas.edu.mx' => 'Angellos Pérez',
		'marisolhg@uas.edu.mx' => 'Marisol Herrera',
	];
	
	protected const array PROFILE = [
		'from' => self::FROM,
		'bcc' => self::BCC,
		'emailFormat' => 'html',
	];
	
	public function __construct() {
		parent::__construct(self::PROFILE);
		
		TransportFactory::setConfig('GoogleTransport', [
			'host' => 'smtp.gmail.com',
			'port' => 587,
			'username' => 'radio@uas.edu.mx',
			'password' => 'sfzvholhfjccuqaz',
			'className' => 'Smtp',
			'tls' => true,
		]);
		
		$this->setTransport('GoogleTransport');
	}
}