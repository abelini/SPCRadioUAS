<?php

namespace App\Mailer\Transport;

use Cake\Mailer\Transport\SmtpTransport;
use Cake\Mailer\Message;


class GoogleTransport extends SmtpTransport
{

	private const array CONFIG = [
		'host' => 'smtp.gmail.com',
		'port' => 587,
		'username' => 'radio@uas.edu.mx',
		'password' => 'sfzvholhfjccuqaz',
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