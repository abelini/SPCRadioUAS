<?php
declare(strict_types=1);

namespace SPC\Controller\Admin;

use SPC\Controller\AppController;
use Cake\Collection\Collection;
use Cake\Http\Response;
use Cake\I18n\DateTime;
use Cake\Mailer\MailerAwareTrait;
use Cake\ORM\Query;


class RolesController extends AppController
{

	use MailerAwareTrait;

	protected array $paginate = [
		'limit' => 40,
	];

	public function index(): Response
	{
		$query = $this->Roles
			->find()
			->contain(['Turnos'])
			->orderByDesc('fechaInicio');

		$roles = $this->paginate($query);

		$this->set(compact('roles'));
		return $this->render();
	}

	public function view($id = null)
	{
		$rol = $this->Roles->get($id, contain: [
			'Asignaciones' => function (Query $query) {
				return $query->orderByAsc('horaInicio')
					->contain([
						'Locutores' => function (Query $query) {
							return $query->select(['ID', 'name']);
						},
						'Horarios',
						'Dias'
					]);
			},
			'Turnos'
		]);

		$weekStart = clone $rol->fechaInicio;
		$asignaciones = (new Collection($rol->asignaciones))
			->groupBy(fn($a) => (clone $weekStart)->addDays($a->diaID - 1)->toDateString())
			->toArray();

		ksort($asignaciones);

		$this->set(compact('rol', 'asignaciones'));
	}

	public function add(): Response
	{
		$rol = $this->Roles->newEmptyEntity();

		if ($this->request->is('post')) {
			$requestedStartDate = new DateTime($this->request->getData('fechaInicio'));
			$previousRol = $this->Roles->find()->where(['fechaInicio' => $requestedStartDate])->first();
			if ($previousRol === null) {
				$rol = $this->Roles->patchEntity($rol, $this->request->getData(), ['associated' => ['Asignaciones']]);
				if ($this->Roles->save($rol, ['associated' => ['Asignaciones']])) {
					$this->Flash->success('Rol de cabina guardado');
					//$this->getMailer('Rol')->new($rol->ID);
					return $this->redirect(['action' => 'index']);
				}
			} else {
				$this->Flash->error('Ya existe un rol para esa semana. Primero elimína el rol #' . $previousRol->ID . ' y después vuelve a registrar uno nuevo.');
				return $this->redirect($this->referer());
			}
			$this->Flash->error('The rol could not be saved. Please, try again.');
		}
		$turnos = $this->Roles->Turnos->find('list')->all();
		$this->set(compact('rol', 'turnos'));

		return $this->render();
	}

	public function edit($id = null)
	{
		$role = $this->Roles->get($id, contain: []);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$role = $this->Roles->patchEntity($role, $this->request->getData());
			if ($this->Roles->save($role)) {
				$this->Flash->success(__('The role has been saved.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('The role could not be saved. Please, try again.'));
		}
		$turnos = $this->Roles->Turnos->find('list', limit: 200)->all();
		$this->set(compact('role', 'turnos'));
	}

	public function delete($id = null)
	{
		$this->request->allowMethod(['post', 'delete']);
		$role = $this->Roles->get($id);
		if ($this->Roles->delete($role)) {
			$this->Flash->success(__('The role has been deleted.'));
		} else {
			$this->Flash->error(__('The role could not be deleted. Please, try again.'));
		}

		return $this->redirect(['action' => 'index']);
	}
}