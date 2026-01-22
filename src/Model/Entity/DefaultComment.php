<?php
declare(strict_types=1);

namespace SPC\Model\Entity;

use Cake\I18n\DateTime;


class DefaultComment
{

	public string $created_time;

	public string $message;

	public DefaultUser $from;


	public function __construct()
	{
		$this->from = new DefaultUser();
		$this->created_time = (new DateTime(timezone: new \DateTimeZone('America/Mazatlan')))->i18nFormat("hh:mm:ss aaa");
		$this->message = 'No hay comentarios...';
	}

}

class DefaultUser
{

	public string $name = 'Auto-response';

}
