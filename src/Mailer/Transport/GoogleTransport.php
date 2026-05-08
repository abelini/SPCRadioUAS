<?php

namespace SPC\Mailer\Transport;

use Cake\Mailer\Transport\SmtpTransport;
use Cake\Mailer\Message;
use Cake\Core\Configure;
use Cake\Log\Log;
use InvalidArgumentException;

class GoogleTransport extends SmtpTransport
{
	private const SMTP_HOST = 'smtp.gmail.com';
	private const SMTP_PORT = 587;
	private const SMTP_TIMEOUT = 30;

	private array $googleSmtpConfig = [
		'host' => self::SMTP_HOST,
		'port' => self::SMTP_PORT,
		'timeout' => self::SMTP_TIMEOUT,
		'className' => 'Smtp',
		'tls' => true,
	];

	/**
	 * Inicializa el transporte SMTP de Google con credenciales configuradas
	 * 
	 * @throws InvalidArgumentException Si faltan las credenciales
	 */
	public function __construct()
	{
		$email = Configure::read('SensitiveData.GoogleMail.email');
		$password = Configure::read('SensitiveData.GoogleMail.password');

		if (empty($email) || empty($password)) {
			throw new InvalidArgumentException(
				'Las credenciales de Google Mail no están configuradas correctamente'
			);
		}

		$config = array_merge($this->googleSmtpConfig, [
			'username' => $email,
			'password' => $password,
		]);

		parent::__construct($config);
	}

	/**
	 * Envía el mensaje de correo electrónico a través de Gmail
	 * 
	 * @param Message $message Mensaje a enviar
	 * @return array Resultado del envío
	 */
	public function send(Message $message): array
	{
		try {
			return parent::send($message);
		} catch (\Exception $exception) {
			Log::error('Error enviando email via Google: ' . $exception->getMessage(), [
				'exception' => $exception,
			]);
			throw $exception;
		}
	}
}