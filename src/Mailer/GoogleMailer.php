<?php

namespace App\Mailer;

use App\Mailer\Transport\GoogleTransport;
use Cake\Mailer\Mailer;
use Cake\Mailer\TransportFactory;


class GoogleMailer extends Mailer
{

	private const array FROM = [
		'radio@uas.edu.mx' => 'Dirección de Radio UAS'
	];

	private const array CC = [
		'abel@uas.edu.mx' => 'Ing. Abel Bottello',
		'angelloperez@uas.edu.mx' => 'Angellos Pérez',
		'brenda@uas.edu.mx' => 'Brenda Rodríguez',
	];

	protected const array GENERAL_PROFILE = [
		'from' => self::FROM,
		'cc' => self::CC,
		'emailFormat' => 'html',
	];

	public function __construct()
	{
		parent::__construct(self::GENERAL_PROFILE);

		$this->setTransport(new GoogleTransport());
	}
}