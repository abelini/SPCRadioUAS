<?php
declare(strict_types=1);

namespace SPC\Model\Entity;

use Cake\Utility\Security;


class Usuario extends Worker
{

	protected array $_accessible = [
		'empleado' => true,
		'username' => true,
		'password' => true,
		'name' => true,
		'fullname' => true,
		'email' => true,
		'base' => true,
		'photo' => true,
		'permisos' => true,
	];

	public function getProfilePicture(): string
	{
		return parent::getProfilePictureUrl();
	}

	protected function _setPassword($password)
	{
		return password_hash($password, PASSWORD_DEFAULT);
	}

	/**
	 * Genera un string random de 18 caracteres, lo hashea y lo guarda en el Usuario
	 *
	 * @return string
	 */
	public function generateAndSetPassword(): string
	{
		$password = Security::randomString(18);
		$this->set('password', $password);
		return $password;
	}
}

