<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Http\Response;
use Cake\I18n\DateTime;

class IncidenciasController extends AppController {

	public function index() {
		$query = $this->Incidencias->find()->contain(['Areas', 'Updates'])->orderByDesc('fecha');
		$incidencias = $this->paginate($query);
		$this->set(compact('incidencias'));
	}
	
	public function close() : Response { //debug($this);
		$incidencia = $this->Incidencias->get($this->request->getQuery('ID'));
		if ($this->request->is('put')) {
			$incidencia->set('closed', true);
			if ($this->Incidencias->save($incidencia)) {
				$this->Flash->success('Incidencia cerrada');
				
			}
			$this->Flash->error(__('The incidencia could not be saved. Please, try again.'));
		} else {
			$this->Flash->error('HTTP Method not allowed');
		}

		return $this->redirect($this->referer());
	}
	
	public function view($id = null) {
		$incidencia = $this->Incidencias->get($id, contain: ['Areas', 'DetallesIncidencias', 'Updates', 'Updates.Usuarios']);
		$comment = $this->Incidencias->Updates->newEmptyEntity();
		$comment->set('incidenciaID', (int) $id);
		$date = new DateTime();
		$this->set(compact('incidencia', 'comment', 'date'));
	}
	/*
	public function add() {
        $bitacoraVigilancium = $this->BitacoraVigilancia->newEmptyEntity();
        if ($this->request->is('post')) {
            $bitacoraVigilancium = $this->BitacoraVigilancia->patchEntity($bitacoraVigilancium, $this->request->getData());
            if ($this->BitacoraVigilancia->save($bitacoraVigilancium)) {
                $this->Flash->success(__('The bitacora vigilancium has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The bitacora vigilancium could not be saved. Please, try again.'));
        }
        $vigilantes = $this->BitacoraVigilancia->Vigilantes->find('list', limit: 200)->all();

        $this->set(compact('bitacoraVigilancium', 'vigilantes',));
	}*/

	public function edit($id = null) {
		$incidencia = $this->Incidencias->get($id, contain: ['Areas', 'DetallesIncidencias']);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$incidencia = $this->Incidencias->patchEntity($incidencia, $this->request->getData());
			if ($this->Incidencias->save($incidencia)) {
				$this->Flash->success(__('The incidencia vigilancium has been saved.'));
				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('The incidencia vigilancium could not be saved. Please, try again.'));
		}
		$areas = $this->Incidencias->Areas->find('list')->all();
		$this->set(compact('incidencia', 'areas',));
	}

	public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $incidencia = $this->Incidencias->get($id);
        if ($this->Incidencias->delete($incidencia)) {
            $this->Flash->success(__('The bitacora vigilancium has been deleted.'));
        } else {
            $this->Flash->error(__('The bitacora vigilancium could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
	}
}
