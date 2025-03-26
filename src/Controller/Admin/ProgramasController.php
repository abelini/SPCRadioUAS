<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use App\Model\Entity\Programa;
use App\Model\Entity\ReportesPrograma;
use Cake\Database\Expression\QueryExpression;
use Cake\Collection\Collection;
use Cake\I18n\DateTime;
use Cake\ORM\Query\SelectQuery;
use NumberToWords\NumberToWords;


class ProgramasController extends AppController {
	
	public function index() {
		$query = $this->Programas->find()
								->orderAsc('name');
		$programas = $this->paginate($query);

		$this->set(compact('programas'));
	}

	public function view($id = null) {
		$programa = $this->Programas->get($id, contain: ['Dias']);
		//$this->set(compact('programa'));
		
		$this->getReportByProgram($programa);
		
	}

	protected function getReportByProgram(Programa $programa) {
		
		$programa = $this->Programas->loadInto($programa, ['ReportesProgramas' => function(SelectQuery $query) {
			return $query->matching('ReportesCabinas', function(SelectQuery $query) {
				return $query->matching('BitacoraCabina', function(SelectQuery $query) {
					return $query->where(function(QueryExpression $exp) {
						return $exp->between('fecha', new DateTime(ReportesPrograma::REPORTING_START_DATE), DateTime::now());
					});
				});
			});
		}]);
		//$star = $start;
		$reportes = new Collection($programa->reportes);
		$groupedReportes = $reportes->groupBy('status')->toArray();
		$statusLongText = ReportesPrograma::STATUS_LONGTEXT_FOR_1P;

		if(!isset($groupedReportes['V'])) $groupedReportes['V'] = []; if(!isset($groupedReportes['G'])) $groupedReportes['G'] = [];
		if(!isset($groupedReportes['S'])) $groupedReportes['S'] = []; if(!isset($groupedReportes['X'])) $groupedReportes['X'] = [];
		
		$ocurrences = [
			'V' => $groupedReportes['V'],
			'G' => $groupedReportes['G'],
			'S' => $groupedReportes['S'],
			'X' => $groupedReportes['X']
		];
		$programa->set('XtoWord', NumberToWords::transformNumber('es', count($groupedReportes['X'])));
		
		$fechaInicial = new DateTime(ReportesPrograma::REPORTING_START_DATE);
		$fechaFinal = DateTime::now();
		
		$diff = $this->getDateDiffString($fechaFinal->diff($fechaInicial));
		
		$this->set(compact('programa', 'reportes', 'ocurrences', 'statusLongText', 'fechaInicial', 'diff'));
		
	}

	protected function getDateDiffString(\DateInterval $diff) : string {
	    return $diff->y .' años, '. $diff->m .' meses y '. $diff->d .' días';
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
        $this->set(compact('programa', 'dias'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Programa id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $programa = $this->Programas->get($id, contain: ['Dias']);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $programa = $this->Programas->patchEntity($programa, $this->request->getData());
            if ($this->Programas->save($programa)) {
                $this->Flash->success(__('The programa has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The programa could not be saved. Please, try again.'));
        }
        $dias = $this->Programas->Dias->find('list', limit: 200)->all();
        $this->set(compact('programa', 'dias'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Programa id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $programa = $this->Programas->get($id);
        if ($this->Programas->delete($programa)) {
            $this->Flash->success(__('The programa has been deleted.'));
        } else {
            $this->Flash->error(__('The programa could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
