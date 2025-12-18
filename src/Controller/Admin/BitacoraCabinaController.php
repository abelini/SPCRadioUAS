<?php
declare(strict_types=1);

namespace SPC\Controller\Admin;

use SPC\Controller\AppController;
use Cake\Event\EventInterface;
use Cake\Http\Response;
use Cake\I18n\DateTime;
use Cake\ORM\Table;


class BitacoraCabinaController extends AppController
{

	public function index(): Response
	{
		$query = $this->BitacoraCabina->find()->orderByDesc('fecha');
		$bitacoras = $this->paginate($query);

		$this->set(compact('bitacoras'));
		return $this->render();
	}

	public function view($id = null): Response
	{
		$bitacora = $this->BitacoraCabina->get($id, contain: ['ReportesCabinas', 'ReportesCabinas.Locutores', 'ReportesCabinas.ReportesProgramas', 'ReportesCabinas.ReportesProgramas.Programas']);
		$this->set(compact('bitacora'));
		return $this->render();
	}

	public function reportes(): Response
	{
		$this->setViewVars();

		return $this->render();
	}

	public function getReportBy()
	{
		if ($this->request->getQuery('t')) {
			return match ($this->request->getQuery('t')) {
				'1P' => $this->getReportByProgramByMonth($this->request->getQuery('p'), $this->request->getQuery('m')),
				'1M' => $this->render(),
				'4M' => $this->render(),
				default => $this->render(),
			};
		}
		//return $this->render();
	}

	protected function getReportByProgramByMonth(string $p, string $m): Response
	{
		$programa = $this->ProgramsRepository
			->get((int) $p);


		$this->set(compact('programa'));
		$this->viewBuilder()
			//->setLayout('ajax')
			->setTemplate('by_1p');
		return $this->render();
	}

	protected function setViewVars(): void
	{
		$programas = $this->ProgramsRepository
			->find('list')
			->orderAsc('name')
			->all();
		$end = DateTime::now();
		$start = $end->addYears(-1);
		$interval = new \DateInterval('P1M');
		$period = new \DatePeriod($start, $interval, $end, \DatePeriod::INCLUDE_END_DATE);
		$meses = [];
		foreach ($period as $date) {
			$meses[$date->format('Y-m')] = (new DateTime($date))->i18nFormat("MMMM 'de' YYYY");
		}

		//$meses =		


		$this->set(compact('programas', 'meses'));
	}

	public function add()
	{
		$bitacora = $this->BitacoraCabina->newEmptyEntity();
		if ($this->request->is('post')) {
			$bitacora = $this->BitacoraCabina->patchEntity($bitacora, $this->request->getData());
			if ($this->BitacoraCabina->save($bitacora)) {
				$this->Flash->success(__('The bitacora cabina has been saved.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('The bitacora cabina could not be saved. Please, try again.'));
		}
		$this->set(compact('bitacora'));
	}


	/**
	 * Delete method
	 *
	 * @param string|null $id Bitacora Cabina id.
	 * @return \Cake\Http\Response|null Redirects to index.
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function delete($id = null)
	{
		$this->request->allowMethod(['post', 'delete']);
		$bitacoraCabina = $this->BitacoraCabina->get($id);
		if ($this->BitacoraCabina->delete($bitacoraCabina)) {
			$this->Flash->success(__('The bitacora cabina has been deleted.'));
		} else {
			$this->Flash->error(__('The bitacora cabina could not be deleted. Please, try again.'));
		}

		return $this->redirect(['action' => 'index']);
	}
}

