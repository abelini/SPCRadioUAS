<?php
declare(strict_types=1);

namespace SPC\Controller;

use SPC\Model\Entity\Permiso;
use SPC\Model\Entity\Usuario;
use Cake\Controller\Controller;
//use Cake\Datasource\EntityInterface;
use Cake\Event\EventInterface;
use Cake\I18n\DateTime;


class AppController extends Controller
{

	protected Usuario $user;

	protected static DateTime $datetime;

	protected const string APP_NAME = 'SISTEMA DE PRODUCCIÓN Y CABINA';

	protected const string LOGO = 'https://radio.uas.edu.mx/wp-content/images/logo.webp';

	protected const string VERSION = '3.5.1';

	protected array $paginate = [
		'limit' => 40,
	];

	public function beforeFilter(EventInterface $event)
	{
		parent::beforeFilter($event);

		$layout = 'home';
		self::$datetime = DateTime::now();
		$auth = $this->Authentication->getResult();
		if ($auth->isValid()) {
			$this->user = $this->getTableLocator()
				->get('Usuarios')
				->find()
				->where(['ID' => $this->Authentication->getIdentity()->get('ID')])
				->contain('Permisos')
				->first();

			$layout = match ($this->user->permisos[0]->name) {
				Permiso::ADMINISTRATOR => strtolower(Permiso::ADMINISTRATOR),
				Permiso::CAPTURISTA => strtolower(Permiso::CAPTURISTA),
				Permiso::FONOTECARIO => strtolower(Permiso::FONOTECARIO),
				default => 'default',
			};
		}
		$this->viewBuilder()->setLayout($layout);

		$this->set('AppName', self::APP_NAME);
		$this->set('AppLogo', self::LOGO);
		$this->set('AppVersion', self::VERSION);
		$this->set('datetime', self::$datetime);
	}

	public function initialize(): void
	{
		parent::initialize();

		$this->loadComponent('Flash');
		$this->loadComponent('Authentication.Authentication');
		//$this->loadComponent('FormProtection');
	}
}

