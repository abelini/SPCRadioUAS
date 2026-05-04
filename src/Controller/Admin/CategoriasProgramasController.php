<?php
declare(strict_types=1);

namespace SPC\Controller\Admin;

use SPC\Controller\AppController;

/**
 * CategoriasProgramas Controller
 *
 * @property \SPC\Model\Table\CategoriasProgramasTable $CategoriasProgramas
 */
class CategoriasProgramasController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->CategoriasProgramas->find();
        $categoriasProgramas = $this->paginate($query);

        $this->set(compact('categoriasProgramas'));
    }

    /**
     * View method
     *
     * @param string|null $id Categorias Programa id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $category = $this->CategoriasProgramas->get($id, contain: ['Programas']);
        $this->set(compact('category'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $categoriasPrograma = $this->CategoriasProgramas->newEmptyEntity();
        if ($this->request->is('post')) {
            $categoriasPrograma = $this->CategoriasProgramas->patchEntity($categoriasPrograma, $this->request->getData());
            if ($this->CategoriasProgramas->save($categoriasPrograma)) {
                $this->Flash->success(__('The categorias programa has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The categorias programa could not be saved. Please, try again.'));
        }
        $this->set(compact('categoriasPrograma'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Categorias Programa id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $categoriasPrograma = $this->CategoriasProgramas->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $categoriasPrograma = $this->CategoriasProgramas->patchEntity($categoriasPrograma, $this->request->getData());
            if ($this->CategoriasProgramas->save($categoriasPrograma)) {
                $this->Flash->success(__('The categorias programa has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The categorias programa could not be saved. Please, try again.'));
        }
        $this->set(compact('categoriasPrograma'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Categorias Programa id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $categoriasPrograma = $this->CategoriasProgramas->get($id);
        if ($this->CategoriasProgramas->delete($categoriasPrograma)) {
            $this->Flash->success(__('The categorias programa has been deleted.'));
        } else {
            $this->Flash->error(__('The categorias programa could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
