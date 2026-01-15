<?php
declare(strict_types=1);

namespace SPC\Controller\Admin;

use SPC\Controller\AppController;

/**
 * TemasProgramas Controller
 *
 * @property \SPC\Model\Table\TemasProgramasTable $TemasProgramas
 */
class TemasProgramasController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->TemasProgramas->find()
            ->contain(['Programas']);
        $temasProgramas = $this->paginate($query);

        $this->set(compact('temasProgramas'));
    }

    /**
     * View method
     *
     * @param string|null $id Temas Programa id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $temasPrograma = $this->TemasProgramas->get($id, contain: ['Programas']);
        $this->set(compact('temasPrograma'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $temasPrograma = $this->TemasProgramas->newEmptyEntity();
        if ($this->request->is('post')) {
            $temasPrograma = $this->TemasProgramas->patchEntity($temasPrograma, $this->request->getData());
            if ($this->TemasProgramas->save($temasPrograma)) {
                $this->Flash->success(__('The temas programa has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The temas programa could not be saved. Please, try again.'));
        }
        $programas = $this->TemasProgramas->Programas->find('list', limit: 200)->all();
        $this->set(compact('temasPrograma', 'programas'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Temas Programa id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $temasPrograma = $this->TemasProgramas->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $temasPrograma = $this->TemasProgramas->patchEntity($temasPrograma, $this->request->getData());
            if ($this->TemasProgramas->save($temasPrograma)) {
                $this->Flash->success(__('The temas programa has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The temas programa could not be saved. Please, try again.'));
        }
        $programas = $this->TemasProgramas->Programas->find('list', limit: 200)->all();
        $this->set(compact('temasPrograma', 'programas'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Temas Programa id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $temasPrograma = $this->TemasProgramas->get($id);
        if ($this->TemasProgramas->delete($temasPrograma)) {
            $this->Flash->success(__('The temas programa has been deleted.'));
        } else {
            $this->Flash->error(__('The temas programa could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
