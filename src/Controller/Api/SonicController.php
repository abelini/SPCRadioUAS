<?php
declare(strict_types=1);

namespace App\Controller\Api;

use App\Controller\AppController;

/**
 * Sonic Controller
 *
 */
class SonicController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Sonic->find();
        $sonic = $this->paginate($query);

        $this->set(compact('sonic'));
    }

    /**
     * View method
     *
     * @param string|null $id Sonic id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $sonic = $this->Sonic->get($id, contain: []);
        $this->set(compact('sonic'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $sonic = $this->Sonic->newEmptyEntity();
        if ($this->request->is('post')) {
            $sonic = $this->Sonic->patchEntity($sonic, $this->request->getData());
            if ($this->Sonic->save($sonic)) {
                $this->Flash->success(__('The sonic has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The sonic could not be saved. Please, try again.'));
        }
        $this->set(compact('sonic'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Sonic id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $sonic = $this->Sonic->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $sonic = $this->Sonic->patchEntity($sonic, $this->request->getData());
            if ($this->Sonic->save($sonic)) {
                $this->Flash->success(__('The sonic has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The sonic could not be saved. Please, try again.'));
        }
        $this->set(compact('sonic'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Sonic id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $sonic = $this->Sonic->get($id);
        if ($this->Sonic->delete($sonic)) {
            $this->Flash->success(__('The sonic has been deleted.'));
        } else {
            $this->Flash->error(__('The sonic could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
