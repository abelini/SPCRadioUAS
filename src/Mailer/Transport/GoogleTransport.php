<?php

namespace SPC\Mailer\Transport;

use Cake\Mailer\Transport\SmtpTransport;
use Cake\Mailer\Message;
use Cake\Core\Configure;

class GoogleTransport extends SmtpTransport
{

	private array $googleSmtpConfig = [
		'host' => 'smtp.gmail.com',
		'port' => 587,
		'className' => 'Smtp',
		'tls' => true,
	];

	public function __construct()
	{
		$config = array_merge($this->googleSmtpConfig, [
			'username' => Configure::read('SensitiveData.GoogleMail.username'),
			'password' => Configure::read('SensitiveData.GoogleMail.password'),
		]);
		parent::__construct($config);
	}

	public function send(Message $message): array
	{
		return parent::send($message);
	}
}
