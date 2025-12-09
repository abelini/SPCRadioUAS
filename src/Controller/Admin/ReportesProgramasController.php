<?php
declare(strict_types=1);

namespace SPC\Controller\Admin;

use SPC\Controller\AppController;
use SPC\Model\Entity\ReportesPrograma;
use Cake\Http\Response;
use Cake\ORM\Query\SelectQuery;


class ReportesProgramasController extends AppController
{

	public function index()
	{
		$query = $this->ReportesProgramas->find()
			->contain(['ReportesCabinas', 'Programas']);
		$reportesProgramas = $this->paginate($query);

		$this->set(compact('reportesProgramas'));
	}

	public function view($id = null)
	{
		$reporte = $this->ReportesProgramas->get($id, contain: ['Programas', 'ReportesCabinas', 'ReportesCabinas.Locutores', 'ReportesCabinas.BitacoraCabina']);
		$this->set(compact('reporte'));
	}

	public function addMissing($rcID)
	{
		$reportesPrograma = $this->ReportesProgramas->newEmptyEntity();
		if ($this->request->is('post')) {
			$reportesPrograma = $this->ReportesProgramas->patchEntity($reportesPrograma, $this->request->getData());
			if ($this->ReportesProgramas->save($reportesPrograma)) {
				$this->Flash->success('Reporte guardado');
				$rc = $this->ReportesProgramas->ReportesCabinas->get($rcID);

				return $this->redirect(['controller' => 'BitacoraCabina', 'action' => 'view', $rc->bitacoraID]);
			}
			$this->Flash->error(__('The reportes programa could not be saved. Please, try again.'));
		}

		$rc = $this->ReportesProgramas->ReportesCabinas->get($rcID, 'AllAssociatedData');
		$rcDesc = 'Reporte #' . $rcID . ' / Operador: ' . $rc->locutor->name . ' / Fecha: ' . $rc->bitacora->fecha->i18nFormat();
		$reportesPrograma->set('ReporteCabinaID', $rcID);
		$programas = $this->ReportesProgramas->Programas->find('list', limit: 200)->all();
		$status = ReportesPrograma::STATUS_LONG_OPTIONS;
		$this->set(compact('reportesPrograma', 'programas', 'status', 'rc', 'rcDesc'));
		return $this->render();

	}

	public function add()
	{
		$reportesPrograma = $this->ReportesProgramas->newEmptyEntity();
		if ($this->request->is('post')) {
			$reportesPrograma = $this->ReportesProgramas->patchEntity($reportesPrograma, $this->request->getData());
			if ($this->ReportesProgramas->save($reportesPrograma)) {
				$this->Flash->success(__('The reportes programa has been saved.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('The reportes programa could not be saved. Please, try again.'));
		}
		$reportesCabinas = $this->ReportesProgramas->ReportesCabinas->find('list')->limit(100)->orderDesc('ID')->all();
		$programas = $this->ReportesProgramas->Programas->find('list', limit: 200)->all();
		$this->set(compact('reportesPrograma', 'reportesCabinas', 'programas'));
	}

	public function edit($id = null): Response
	{
		$reportePrograma = $this->ReportesProgramas->get($id, contain: ['Programas']);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$reportePrograma = $this->ReportesProgramas->patchEntity($reportePrograma, $this->request->getData());
			if ($this->ReportesProgramas->save($reportePrograma)) {
				$reportePrograma = $this->ReportesProgramas->loadInto($reportePrograma, [
					'ReportesCabinas' => function (SelectQuery $query) {
						return $query->select(['bitacoraID']);
					}
				]);
				$this->Flash->success('Reporte de programa actualizado');
				return $this->redirect(['controller' => 'BitacoraCabina', 'action' => 'view', $reportePrograma->reporte->bitacoraID]);
			}
			$this->Flash->error('The reportes programa could not be saved. Please, try again.');
			return $this->redirect(['controller' => 'BitacoraCabina', 'action' => 'index']);
		}
		$statuses = ReportesPrograma::STATUS_LONG_OPTIONS;
		$this->set(compact('reportePrograma', 'statuses'));

		return $this->render();
	}

	public function delete($id = null): Response
	{
		$this->request->allowMethod(['delete']);
		$reportePrograma = $this->ReportesProgramas->get($id);
		$rc = $this->ReportesProgramas
			->ReportesCabinas
			->find()
			->select(['bitacoraID'])
			->where(['ID' => $reportePrograma->ReporteCabinaID])
			->first();

		if ($this->ReportesProgramas->delete($reportePrograma)) {
			$this->Flash->success('Reporte de programa eliminado');
		} else {
			$this->Flash->error(__('The reportes programa could not be deleted. Please, try again.'));
		}

		return $this->redirect(['controller' => 'BitacoraCabina', 'action' => 'view', $rc->bitacoraID]);
	}
}

