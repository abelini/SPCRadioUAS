<?php
declare(strict_types=1);

namespace SPC\Controller\Admin;

use SPC\Controller\AppController;
use Cake\Http\Response;
use Cake\I18n\DateTime;
use Cake\ORM\Query;


class AsignacionesController extends AppController
{

	public function generate(): Response
	{
		if ($this->request->isPost()) {
			$offset = 0;
			$starts = new DateTime($this->request->getData('starts'));
			$turno = $this->getTableLocator()
				->get('Dias')
				->find()
				->contain('Horarios', function (Query $query) {
					return $query->matching('Turnos', function (Query $query) {
						return $query->where(['Turnos.ID' => $this->request->getData('turno')]);
					});
				})
				->all();

			$locutores = $this->getTableLocator()
				->get('Locutores')
				->find('list')
				->toArray();


			$this->set(compact('starts', 'turno', 'locutores', 'offset'));

			$this->viewBuilder()->setLayout('ajax');
			return $this->render();
		}
	}




	public function index()
	{
		$query = $this->Asignaciones->find()
			->contain(['Locutores', 'Dias', 'Horarios']);
		$asignaciones = $this->paginate($query);

		$this->set(compact('asignaciones'));
	}

	public function view($id = null)
	{
		$asignacion = $this->Asignaciones->get($id, contain: ['Locutores', 'Dias', 'Horarios']);
		$this->set(compact('asignacion'));
	}

	public function add()
	{
		$asignacione = $this->Asignaciones->newEmptyEntity();
		if ($this->request->is('post')) {
			$asignacione = $this->Asignaciones->patchEntity($asignacione, $this->request->getData());
			if ($this->Asignaciones->save($asignacione)) {
				$this->Flash->success(__('The asignacione has been saved.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('The asignacione could not be saved. Please, try again.'));
		}
		//$usuarios = $this->Asignaciones->Usuarios->find('list', limit: 200)->all();
		$dias = $this->Asignaciones->Dias->find('list', limit: 200)->all();
		$horarios = $this->Asignaciones->Horarios->find('list', limit: 200)->all();
		$this->set(compact('asignacione', 'usuarios', 'dias', 'horarios'));
	}

	public function edit($id = null)
	{
		$asignacion = $this->Asignaciones->get($id, contain: []);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$asignacion = $this->Asignaciones->patchEntity($asignacion, $this->request->getData());
			if ($this->Asignaciones->save($asignacion)) {
				$this->Flash->success('Asignación modificada');
				return $this->redirect(['controller' => 'roles', 'action' => 'view', $asignacion->rolID]);
			}
			$this->Flash->error(__('The asignacione could not be saved. Please, try again.'));
		}
		$asignacion = $this->Asignaciones->loadInto($asignacion, ['Roles', 'Locutores', 'Dias', 'Horarios']);
		$locutores = $this->Asignaciones->Locutores->find('list')->all();
		$dias = $this->Asignaciones->Dias->find('list', limit: 200)->all();
		$horarios = $this->Asignaciones->Horarios->find('list')->all();

		$this->set(compact('asignacion', 'locutores', 'dias', 'horarios'));
	}

	public function delete($id = null)
	{
		$this->request->allowMethod(['post', 'delete']);
		$asignacione = $this->Asignaciones->get($id);
		if ($this->Asignaciones->delete($asignacione)) {
			$this->Flash->success(__('The asignacione has been deleted.'));
		} else {
			$this->Flash->error(__('The asignacione could not be deleted. Please, try again.'));
		}

		return $this->redirect(['action' => 'index']);
	}
}

