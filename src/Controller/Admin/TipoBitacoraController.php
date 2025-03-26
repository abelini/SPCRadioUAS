<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;

/**
 * TipoBitacora Controller
 *
 * @property \App\Model\Table\TipoBitacoraTable $TipoBitacora
 */
class TipoBitacoraController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->TipoBitacora->find();
        $tipoBitacora = $this->paginate($query);

        $this->set(compact('tipoBitacora'));
    }

    /**
     * View method
     *
     * @param string|null $id Tipo Bitacora id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $tipoBitacora = $this->TipoBitacora->get($id, contain: []);
        $this->set(compact('tipoBitacora'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $tipoBitacora = $this->TipoBitacora->newEmptyEntity();
        if ($this->request->is('post')) {
            $tipoBitacora = $this->TipoBitacora->patchEntity($tipoBitacora, $this->request->getData());
            if ($this->TipoBitacora->save($tipoBitacora)) {
                $this->Flash->success(__('The tipo bitacora has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tipo bitacora could not be saved. Please, try again.'));
        }
        $this->set(compact('tipoBitacora'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Tipo Bitacora id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $tipoBitacora = $this->TipoBitacora->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $tipoBitacora = $this->TipoBitacora->patchEntity($tipoBitacora, $this->request->getData());
            if ($this->TipoBitacora->save($tipoBitacora)) {
                $this->Flash->success(__('The tipo bitacora has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tipo bitacora could not be saved. Please, try again.'));
        }
        $this->set(compact('tipoBitacora'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Tipo Bitacora id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $tipoBitacora = $this->TipoBitacora->get($id);
        if ($this->TipoBitacora->delete($tipoBitacora)) {
            $this->Flash->success(__('The tipo bitacora has been deleted.'));
        } else {
            $this->Flash->error(__('The tipo bitacora could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
