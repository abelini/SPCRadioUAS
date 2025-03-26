<?php
declare(strict_types=1);

namespace App\Controller;


class ReportesCabinasController extends AppController {

	public function display() {
		$query = $this->ReportesCabinas->find();
		$reportesCabinas = $this->paginate($query);

		$this->set(compact('reportesCabinas'));
    }

    public function add() {
        $reportesCabina = $this->ReportesCabinas->newEmptyEntity();
        if ($this->request->is('post')) {
            $reportesCabina = $this->ReportesCabinas->patchEntity($reportesCabina, $this->request->getData());
            if ($this->ReportesCabinas->save($reportesCabina)) {
                $this->Flash->success(__('The reportes cabina has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The reportes cabina could not be saved. Please, try again.'));
        }
        $this->set(compact('reportesCabina'));
    }
}
