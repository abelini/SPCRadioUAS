<?php

namespace SPC\Mailer;

use SPC\Mailer\GoogleMailer;
use SPC\Model\Entity\Usuario;
use SPC\Mailer\Transport\GoogleTransport;

class UserMailer extends GoogleMailer
{
	public function __construct()
	{
		parent::__construct(['from' => parent::FROM]);
		$this->setTransport(new GoogleTransport());
	}

	public function welcome($user)
	{
		$this
			->setTo($user->email)
			->setSubject(sprintf('Welcome %s', $user->name));
	}

	public function resetPassword(Usuario $user, string $password, string $app): UserMailer
	{
		$this
			->setTo($user->email, $user->nombres)
			->setEmailFormat('html')
			->setSubject('Recuperación de contraseña')
			->setViewVars([
				'user' => $user,
				'password' => $password,
				'app' => $app,
			])
			->viewBuilder()
			->setTemplate('reset_password');

		$this->deliver();
		return $this;
	}
}
