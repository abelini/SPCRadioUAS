<?php
declare(strict_types=1);

namespace SPC\Controller;

/**
 * ReportesVigilancia Controller
 *
 * @property \App\Model\Table\ReportesVigilanciaTable $ReportesVigilancia
 */
class ReportesVigilanciaController extends SPCController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->ReportesVigilancia->find();
        $reportesVigilancia = $this->paginate($query);

        $this->set(compact('reportesVigilancia'));
    }

    /**
     * View method
     *
     * @param string|null $id Reportes Vigilancium id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $reportesVigilancium = $this->ReportesVigilancia->get($id, contain: []);
        $this->set(compact('reportesVigilancium'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $reportesVigilancium = $this->ReportesVigilancia->newEmptyEntity();
        if ($this->request->is('post')) {
            $reportesVigilancium = $this->ReportesVigilancia->patchEntity($reportesVigilancium, $this->request->getData());
            if ($this->ReportesVigilancia->save($reportesVigilancium)) {
                $this->Flash->success(__('The reportes vigilancium has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The reportes vigilancium could not be saved. Please, try again.'));
        }
        $this->set(compact('reportesVigilancium'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Reportes Vigilancium id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $reportesVigilancium = $this->ReportesVigilancia->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $reportesVigilancium = $this->ReportesVigilancia->patchEntity($reportesVigilancium, $this->request->getData());
            if ($this->ReportesVigilancia->save($reportesVigilancium)) {
                $this->Flash->success(__('The reportes vigilancium has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The reportes vigilancium could not be saved. Please, try again.'));
        }
        $this->set(compact('reportesVigilancium'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Reportes Vigilancium id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $reportesVigilancium = $this->ReportesVigilancia->get($id);
        if ($this->ReportesVigilancia->delete($reportesVigilancium)) {
            $this->Flash->success(__('The reportes vigilancium has been deleted.'));
        } else {
            $this->Flash->error(__('The reportes vigilancium could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

