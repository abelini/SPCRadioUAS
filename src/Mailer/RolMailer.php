<?php

namespace App\Mailer;

use App\Mailer\GoogleMailer;
use App\Model\Entity\Rol;
use Cake\Collection\Collection;
use Cake\ORM\TableRegistry;
use Cake\ORM\Query\SelectQuery;
use Cake\View\Helper\UrlHelper;
use Cake\View\View;


class RolMailer extends GoogleMailer {
	
	public function new(int $rolID) : GoogleMailer {
		$rolesRepository = TableRegistry::getTableLocator()->get('Roles');
		$locutoresRepository = TableRegistry::getTableLocator()->get('Locutores');
		
		$locutores = $locutoresRepository->find('list', keyField:'email', valueField:'name')->all()->toArray();
		
		$rol = $rolesRepository->get($rolID, contain: [
			'Asignaciones' => function(SelectQuery $query) {
				return $query->orderAsc('horaInicio')
							->contain([
								'Locutores' => function(SelectQuery $query) {
									return $query->select(['ID', 'name']);
								},
								'Horarios',
								'Dias'
							]);
			},
			'Turnos'
		]);
		
		$asignaciones = (new Collection($rol->asignaciones))->groupBy('diaID')->toArray();
		
		$url = new UrlHelper(new View());
		$pdfData = file_get_contents($url->build([
					'prefix' => false,
					'controller' => 'Roles',
					'action' => 'view',
					'?' => [
						'rol' => $rolID,
						'action' => 'download',
					],
				],
				['fullBase' => true, 'escape' => false]
			)
		);

		$this
			->setTo($locutores)
			//->setTo(['abelini@gmail.com' => 'Ing. Abel Botello'])
			->setSubject('Rol de cabina ['.$rol->fechaInicio->format('d/m/y').'] a ['.$rol->fechaFin->format('d/m/y').']')
			->setViewVars([
				'rol' => $rol,
				'asignaciones' => $asignaciones,
			])	
			->viewBuilder()
				->addHelpers(['Html', 'Url'])
				->setTemplate('new_rol');
				
		$this->setAttachments([
			'RolCabina-'.$rolID.'.pdf' => [
				'data' => $pdfData,
				'mimetype' => 'application/pdf',
			]
		]);

		$this->deliver();
		
		return $this;
	}
}