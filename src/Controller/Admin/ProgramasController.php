<?php
declare(strict_types=1);

namespace SPC\Controller\Admin;

use SPC\Controller\AppController;
use SPC\Model\Entity\Programa;
use SPC\Model\Entity\ReportesPrograma;
use Cake\Cache\Cache;
use Cake\Http\Response;
use Cake\I18n\DateTime;
use Cake\ORM\Query\SelectQuery;


class ProgramasController extends AppController
{

	public function index()
	{
		$query = $this->Programas->find(admin: true)
			->contain(['CategoriasProgramas'])
			->orderByAsc('Programas.name');
		$programas = $this->paginate($query, ['limit' => 100, 'maxLimit' => 100]);

		$this->set(compact('programas'));
	}
	public function view($id = null)
	{
		$programa = $this->Programas->get(
			$id,
			admin: true,
			contain: [
				'Dias',
				'ReportesProgramas' => function (SelectQuery $query) {
					return $query->matching('ReportesCabinas.BitacoraCabina', function (SelectQuery $query) {
						return $query->where([
							'BitacoraCabina.fecha >=' => new DateTime(ReportesPrograma::REPORTING_START_DATE),
							'BitacoraCabina.fecha <=' => DateTime::now()
						]);
					});
				}
			]
		);

		$this->set($this->_prepareReportData($programa));
	}

	/**
	 * Delegates report grouping to the entity and adds date range metadata for the view.
	 */
	protected function _prepareReportData(Programa $programa): array
	{
		$summary = $programa->getReportSummary();

		$fechaInicial = new DateTime(ReportesPrograma::REPORTING_START_DATE);
		$fechaFinal = DateTime::now();

		return [
			'programa' => $programa,
			'reportes' => $summary['collection'],
			'ocurrences' => $summary['grouped'],
			'statusLongText' => ReportesPrograma::STATUS_LONGTEXT_FOR_1P,
			'fechaInicial' => $fechaInicial,
			'diff' => $this->getDateDiffString($fechaFinal->diff($fechaInicial)),
		];
	}
	protected function getDateDiffString(\DateInterval $diff): string
	{
		return $diff->y . ' años, ' . $diff->m . ' meses y ' . $diff->d . ' días';
	}

	public function switchOnAirStatus(): Response
	{
		$this->request->allowMethod(['post']);
		$ids = $this->request->getData('ids');
		$target = $this->request->getData('target');

		if (empty($ids) || !is_array($ids) || !in_array($target, ['true', 'false'], true)) {
			$this->Flash->error('Parámetros inválidos.');
			return $this->redirect(['action' => 'index']);
		}

		$count = $this->Programas->updateAll(
			['outOfAir' => $target === 'true'],
			['ID IN' => $ids]
		);

		$action = $target === 'true' ? 'Sacados del aire' : 'Enviados al aire';
		$this->Flash->success("{$action}: {$count} programa(s).");
		return $this->redirect(['action' => 'index']);
	}

	public function add()
	{
		$programa = $this->Programas->newEmptyEntity();
		if ($this->request->is('post')) {
			$programa = $this->Programas->patchEntity($programa, $this->request->getData());

			if ($this->Programas->save($programa)) {
				$this->Flash->success(__('The programa has been saved.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('The programa could not be saved. Please, try again.'));
		}
		$dias = $this->Programas->Dias->find('list', limit: 200)->all();
		$categorias = $this->Programas->CategoriasProgramas->find('list')->all();
		$this->set(compact('programa', 'dias', 'categorias'));
	}

	public function edit($id = null)
	{
		$programa = $this->Programas->get($id, admin: true, contain: ['Dias']);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$programa = $this->Programas->patchEntity($programa, $this->request->getData());

			//Borrar cache de la API cuando se edite el programa
			$cacheKey = 'programa_info_' . md5(strtolower(trim($programa->name)));
			Cache::delete($cacheKey, 'programas_api');

			if ($this->Programas->save($programa)) {
				$this->Flash->success(__('The programa has been saved.'));

				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('The programa could not be saved. Please, try again.'));
		}
		$dias = $this->Programas->Dias->find('list', admin: true)->all();
		$categorias = $this->Programas->CategoriasProgramas->find('list')->all();
		$this->set(compact('programa', 'dias', 'categorias'));
	}

	public function delete($id = null)
	{
		$this->request->allowMethod(['post', 'delete']);
		$programa = $this->Programas->get($id, admin: true);
		if ($this->Programas->delete($programa)) {
			$this->Flash->success(__('The programa has been deleted.'));
		} else {
			$this->Flash->error(__('The programa could not be deleted. Please, try again.'));
		}

		return $this->redirect(['action' => 'index']);
	}
}