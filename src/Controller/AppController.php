<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\Permiso;
use Cake\Controller\Controller;
use Cake\Datasource\EntityInterface;
use Cake\Event\EventInterface;


class AppController extends Controller {
	
	public EntityInterface $user;
	
	public const string APP_NAME = 'SISTEMA DE PRODUCCIÓN Y CABINA';
	
	protected array $paginate = [
		'limit' => 40,
	];
    
	public function beforeFilter(EventInterface $event) {
		parent::beforeFilter($event);
		
		$layout = 'home';
		$auth = $this->Authentication->getResult();
		if($auth->isValid()) {
			$this->user = $this->getTableLocator()
							->get('Usuarios')
								->find()
									->where(['ID' => $this->Authentication->getIdentity()->get('ID')])
									->contain('Permisos')
									->first();

			$layout = match($this->user->permisos[0]->name) {
				Permiso::ADMINISTRATOR => strtolower(Permiso::ADMINISTRATOR),
				Permiso::CAPTURISTA => strtolower(Permiso::CAPTURISTA),
				Permiso::FONOTECARIO => strtolower(Permiso::FONOTECARIO),
				default => 'default',
			};
		}
		$this->viewBuilder()->setLayout($layout);
		
		$this->set('AppName', self::APP_NAME);
    }

	public function initialize(): void {
		parent::initialize();

		$this->loadComponent('Flash');
		$this->loadComponent('Authentication.Authentication');
		//$this->loadComponent('FormProtection');
    }
}
