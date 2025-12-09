<?php

namespace SPC\Mailer;

use SPC\Mailer\GoogleMailer;
use SPC\Model\Entity\Usuario;


class UserMailer extends GoogleMailer
{

	public function welcome($user)
	{
		$this
			->setTo($user->email)
			->setSubject(sprintf('Welcome %s', $user->name));


	}

	public function resetPassword(Usuario $user, string $password, string $app): GoogleMailer
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
