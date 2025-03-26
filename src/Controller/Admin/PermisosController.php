<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * Permisos Controller
 *
 * @property \App\Model\Table\PermisosTable $Permisos
 */
class PermisosController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Permisos->find();
        $permisos = $this->paginate($query);

        $this->set(compact('permisos'));
    }

    /**
     * View method
     *
     * @param string|null $id Permiso id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $permiso = $this->Permisos->get($id, contain: ['Usuarios']);
        $this->set(compact('permiso'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $permiso = $this->Permisos->newEmptyEntity();
        if ($this->request->is('post')) {
            $permiso = $this->Permisos->patchEntity($permiso, $this->request->getData());
            if ($this->Permisos->save($permiso)) {
                $this->Flash->success(__('The permiso has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The permiso could not be saved. Please, try again.'));
        }
        $usuarios = $this->Permisos->Usuarios->find('list', limit: 200)->all();
        $this->set(compact('permiso', 'usuarios'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Permiso id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $permiso = $this->Permisos->get($id, contain: ['Usuarios']);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $permiso = $this->Permisos->patchEntity($permiso, $this->request->getData());
            if ($this->Permisos->save($permiso)) {
                $this->Flash->success(__('The permiso has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The permiso could not be saved. Please, try again.'));
        }
        $usuarios = $this->Permisos->Usuarios->find('list', limit: 200)->all();
        $this->set(compact('permiso', 'usuarios'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Permiso id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $permiso = $this->Permisos->get($id);
        if ($this->Permisos->delete($permiso)) {
            $this->Flash->success(__('The permiso has been deleted.'));
        } else {
            $this->Flash->error(__('The permiso could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
