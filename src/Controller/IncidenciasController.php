<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\EventInterface;
use Cake\I18n\DateTime;


class IncidenciasController extends AppController {

	public function initialize() : void {
		parent::initialize();
		$this->Authentication->allowUnauthenticated(['add', 'update']);
	}
	
	public function add() {
		$datetime = DateTime::now();
		$incidencia = $this->Incidencias->newEmptyEntity();
		$incidencia->set('detalles', $this->Incidencias->DetallesIncidencias->newEmptyEntity());
		$incidencia->set('fecha', $datetime);
		
		if ($this->request->is('post')) {
			$attachment = $this->request->getData('attachment');
			if($attachment->getError() == 0) {			
				$file = $datetime->timestamp . '.' . pathinfo($attachment->getClientFilename(), PATHINFO_EXTENSION);
				$path = getcwd() . DS.'img'. DS .'Incidencias'.DS . $file;
				$attachment->moveTo($path);
				$incidencia->set('attachment', $file);
			}
			
			$data = $this->request->getData(); unset($data['attachment']);
			$incidencia = $this->Incidencias->patchEntity($incidencia, $data, ['associated' => ['DetallesIncidencias']]);	

			if($this->Incidencias->save($incidencia)) {
				$this->Flash->success('Reporte guardado.');
				return $this->redirect(['action' => 'add']);
			}
			$this->Flash->error('Error. El reporte no se guardó.');
		}

		$areas = $this->Incidencias->Areas->find('list')->all();
			
		$this->set(compact('incidencia', 'areas'));
	}
	
	public function beforeRender(EventInterface $event) {
		$this->viewBuilder()->setLayout('cabina');
	}
}
