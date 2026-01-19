<?php
declare(strict_types=1);

namespace SPC\Controller\Admin;

use SPC\Controller\AppController;

class TemasProgramasController extends AppController
{

    public function index()
    {
        $query = $this->TemasProgramas->find()
            ->contain(['Programas']);
        $temasProgramas = $this->paginate($query);

        $this->set(compact('temasProgramas'));
    }

    public function view($id = null)
    {
        $temasPrograma = $this->TemasProgramas->get($id, contain: ['Programas']);
        $this->set(compact('temasPrograma'));
    }

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
        $programas = $this->TemasProgramas->Programas->find('list')->all();
        $this->set(compact('temasPrograma', 'programas'));
    }

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
