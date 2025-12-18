<?php

namespace SPC\Mailer;

use SPC\Mailer\Transport\GoogleTransport;
use Cake\Mailer\Mailer;
use Cake\Mailer\TransportFactory;


class GoogleMailer extends Mailer
{

	protected const array FROM = [
		'radio@uas.edu.mx' => 'Dirección de Radio UAS'
	];

	protected const array CC = [
		'abel@uas.edu.mx' => 'Ing. Abel Bottello',
		'angelloperez@uas.edu.mx' => 'Angellos Pérez',
		'brenda@uas.edu.mx' => 'Brenda Rodríguez',
	];

	protected const array GENERAL_PROFILE = [
		'from' => self::FROM,
		'cc' => self::CC,
		'emailFormat' => 'html',
	];

}
