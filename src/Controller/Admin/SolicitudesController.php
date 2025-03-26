<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;


class SolicitudesController extends AppController {

	public function index() {
		$query = $this->Solicitudes
						->find()
							->contain(['TipoSolicitud', 'PrimerAsignado', 'SegundoAsignado', 'Autorizante', 'ProductorTecnico'])
							->orderDesc('fecha');
		$solicitudes = $this->paginate($query);

		$this->set(compact('solicitudes'));
	}

	public function view($id = null) {
		$solicitud = $this->Solicitudes->get($id, contain: ['TipoSolicitud', 'PrimerAsignado', 'SegundoAsignado', 'Autorizante', 'ProductorTecnico']);
		$this->set(compact('solicitud'));
	}

	public function add() {
		$solicitud = $this->Solicitudes->newEmptyEntity();
		if ($this->request->is('post')) {
			$solicitud = $this->Solicitudes->patchEntity($solicitud, $this->request->getData());
			if ($this->Solicitudes->save($solicitud)) {
				$this->Flash->success(__('The solicitud has been saved.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('The solicitud could not be saved. Please, try again.'));
		}
		$tipos = $this->Solicitudes->TipoSolicitud->find('list')->all();
		$primerAsignado = $this->Solicitudes->PrimerAsignado->find('list')->all();
		$segundoAsignado = $this->Solicitudes->SegundoAsignado->find('list')->all();
		$autorizante = $this->Solicitudes->Autorizante->find('list')->all();
		$productorTecnico = $this->Solicitudes->ProductorTecnico->find('list')->all();
		$this->set(compact('solicitud', 'tipos', 'primerAsignado', 'segundoAsignado', 'autorizante', 'productorTecnico'));
    }

	public function edit($id = null) {
		$solicitud = $this->Solicitudes->get($id);
		if ($this->request->is('put')) {
			$solicitud = $this->Solicitudes->patchEntity($solicitud, $this->request->getData());
			if ($this->Solicitudes->save($solicitud)) {
				$this->Flash->success(__('The solicitud has been saved.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('The solicitud could not be saved. Please, try again.'));
		}
		$tipos = $this->Solicitudes->TipoSolicitud->find('list')->all();
		$primerAsignado = $this->Solicitudes->PrimerAsignado->find('list')->all();
		$segundoAsignado = $this->Solicitudes->SegundoAsignado->find('list')->all();
		$autorizante = $this->Solicitudes->Autorizante->find('list')->all();
		$productorTecnico = $this->Solicitudes->ProductorTecnico->find('list')->all();
		$this->set(compact('solicitud', 'tipos', 'primerAsignado', 'segundoAsignado', 'autorizante', 'productorTecnico'));
	}

    /**
     * Delete method
     *
     * @param string|null $id Solicitude id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $solicitude = $this->Solicitudes->get($id);
        if ($this->Solicitudes->delete($solicitude)) {
            $this->Flash->success(__('The solicitude has been deleted.'));
        } else {
            $this->Flash->error(__('The solicitude could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
