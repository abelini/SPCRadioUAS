<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;


class Permiso extends Entity {
	
	public const string ADMINISTRATOR = 'Administrador';
	
	public const string CAPTURISTA = 'Capturista';
	
	public const string FONOTECARIO = 'Programador';
	
	public const int PRODUCTORES_TECNICOS = 3;
	
	public const int CORRESPONSALES = 5;
	
	public const int PROGRAMADOR = 8;
	
	public const int VIGILANTE = 9;
	
	public const int LOCUTOR = 10;
	
	protected array $_accessible = [
		'name' => true,
		'usuarios' => true,
	];
}
