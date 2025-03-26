<?php

namespace App\Mailer;

use App\Mailer\GoogleMailer;


class UserMailer extends GoogleMailer {
	
	public function welcome($user) {
        $this
            ->setTo($user->email)
            ->setSubject(sprintf('Welcome %s', $user->name));
			

	}

    public function resetPassword(User $user, string $password, string $materia) : GoogleMailer {
        $this
			->setTo($user->email, $user->nombres)
			->setEmailFormat('html')
			->setSubject('Recuperación de contraseña')
			->setViewVars([
				'user' => $user,
				'password' => $password,
				'materia' => $materia
			])
			->viewBuilder()
				->setTemplate('reset_password');
				
		$this->deliver();
		return $this;
    }
}