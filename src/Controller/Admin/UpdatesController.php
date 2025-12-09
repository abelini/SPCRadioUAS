<?php
declare(strict_types=1);

namespace SPC\Controller\Admin;

use SPC\Controller\AppController;


class UpdatesController extends AppController
{

	public function index()
	{
		$query = $this->Tickets->find()->contain(['BitacoraVigilancia', 'Usuarios']);
		$tickets = $this->paginate($query);

		$this->set(compact('tickets'));
	}

	public function view($id = null)
	{
		$ticket = $this->Tickets->get($id, contain: ['BitacoraVigilancia', 'Usuarios']);
		$this->set(compact('ticket'));
	}

	public function add()
	{
		$update = $this->Updates->newEmptyEntity();
		if ($this->request->is('post')) {
			$update = $this->Updates->patchEntity($update, $this->request->getData());
			$update->set('userID', $this->Authentication->getIdentity()->get('ID'));
			if ($this->Updates->save($update)) {
				$this->Flash->success('Incidencia actualizada');
				return $this->redirect($this->referer());
			}
			$this->Flash->error('The ticket could not be updated. Please, try again.');
		}
		return $this->redirect($this->referer());
	}

	public function edit($id = null)
	{
		$ticket = $this->Tickets->get($id, contain: []);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$ticket = $this->Tickets->patchEntity($ticket, $this->request->getData());
			if ($this->Tickets->save($ticket)) {
				$this->Flash->success(__('The tickets bitacoras v has been saved.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('The tickets bitacoras v could not be saved. Please, try again.'));
		}
		$bitacoraVigilancia = $this->Tickets->BitacoraVigilancia->find('list', limit: 200)->all();
		$usuarios = $this->Tickets->Usuarios->find('list', limit: 200)->all();
		$this->set(compact('ticket', 'bitacoraVigilancia', 'usuarios'));
	}


	public function delete($id = null)
	{
		$this->request->allowMethod(['post', 'delete']);
		$ticketsBitacorasV = $this->Tickets->get($id);
		if ($this->Tickets->delete($ticketsBitacorasV)) {
			$this->Flash->success(__('The tickets bitacoras v has been deleted.'));
		} else {
			$this->Flash->error(__('The tickets bitacoras v could not be deleted. Please, try again.'));
		}
		return $this->redirect(['action' => 'index']);
	}
}

