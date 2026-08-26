<?php
declare(strict_types=1);

namespace SPC\DTO;

use Cake\I18n\DateTime;


class FBComment
{
	public string $created_time;
	public string $message;
	public FBUser $from;

	public function __construct()
	{
		$this->from = new FBUser();
		$this->created_time = DateTime::now()->i18nFormat("hh:mm:ss aaa");
		$this->message = 'No hay comentarios...';
	}

}