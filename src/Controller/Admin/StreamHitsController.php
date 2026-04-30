<?php
declare(strict_types=1);

namespace SPC\Controller\Admin;

use SPC\Controller\AppController;

/**
 * StreamHits Controller
 *
 * @property \SPC\Model\Table\StreamHitsTable $StreamHits
 */
class StreamHitsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->StreamHits->find();
        $streamHits = $this->paginate($query);

        $this->set(compact('streamHits'));
    }

    /**
     * View method
     *
     * @param string|null $id Stream Hit id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $streamHit = $this->StreamHits->get($id, contain: []);
        $this->set(compact('streamHit'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $streamHit = $this->StreamHits->newEmptyEntity();
        if ($this->request->is('post')) {
            $streamHit = $this->StreamHits->patchEntity($streamHit, $this->request->getData());
            if ($this->StreamHits->save($streamHit)) {
                $this->Flash->success(__('The stream hit has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The stream hit could not be saved. Please, try again.'));
        }
        $this->set(compact('streamHit'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Stream Hit id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $streamHit = $this->StreamHits->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $streamHit = $this->StreamHits->patchEntity($streamHit, $this->request->getData());
            if ($this->StreamHits->save($streamHit)) {
                $this->Flash->success(__('The stream hit has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The stream hit could not be saved. Please, try again.'));
        }
        $this->set(compact('streamHit'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Stream Hit id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $streamHit = $this->StreamHits->get($id);
        if ($this->StreamHits->delete($streamHit)) {
            $this->Flash->success(__('The stream hit has been deleted.'));
        } else {
            $this->Flash->error(__('The stream hit could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
