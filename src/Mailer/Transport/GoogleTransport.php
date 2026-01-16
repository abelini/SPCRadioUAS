<?php

namespace SPC\Mailer\Transport;

use Cake\Mailer\Transport\SmtpTransport;
use Cake\Mailer\Message;
use Cake\Core\Configure;

class GoogleTransport extends SmtpTransport
{

	private const array CONFIG = [
		'host' => 'smtp.gmail.com',
		'port' => 587,
		'username' => Configure::read('SensitiveData.GoogleMail.username'),
		'password' => Configure::read('SensitiveData.GoogleMail.password'),
		'className' => 'Smtp',
		'tls' => true,
	];

	public function __construct()
	{
		parent::__construct(self::CONFIG);
	}

	public function send(Message $message): array
	{
		return parent::send($message);
	}
}
