<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;


class Usuario extends Worker {
	
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
	
	protected function _setPassword($password){
        return password_hash($password, PASSWORD_DEFAULT);
    }
    
    public function generateAndSetPassword() : string {
	    $password = substr(password_hash(strval(time()), PASSWORD_DEFAULT), 0, 10);
	    $this->password = $password;
	    return $password;
    }	
}
