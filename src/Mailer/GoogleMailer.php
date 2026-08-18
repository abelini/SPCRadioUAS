<?php

namespace SPC\Mailer;

use Cake\Mailer\Mailer;


class GoogleMailer extends Mailer
{
	private const array TEST_TO = [
		'abelini@gmail.com' => 'Ing. Abel Bottello'
	];

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

	protected const array TEST_PROFILE = [
		'to' => self::TEST_TO,
		'from' => self::FROM,
		'emailFormat' => 'html',
	];

}
