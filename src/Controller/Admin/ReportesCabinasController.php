<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use App\Model\Entity\ReportesPrograma;
use Cake\Collection\Collection;
use Cake\Collection\CollectionInterface;
use Cake\Database\Expression\QueryExpression;
use Cake\Event\EventInterface;
use Cake\Http\Response;
use Cake\I18n\DateTime;
use Cake\ORM\Query\SelectQuery;
use Cake\ORM\Table;
use NumberToWords\NumberToWords;

class ReportesCabinasController extends AppController {
	
	protected const string REPORTING_START_DATE = 'May 1, 2022';
	
	protected const string YR_PERIOD_START_DATE = 'Jun 8, 2022';
	
	protected Table $ProgramsRepository;
	
	protected static DateTime $reportStart;
	
	protected static DateTime $reportEnd;
	
	public function beforeFilter(EventInterface $event) : void {
		parent::beforeFilter($event);
		$this->ProgramsRepository = $this->getTableLocator()->get('Programas');
	}
	
	public function reportes() : Response {
		$this->setViewVars();
		return $this->render();
	}
	
	/**
	 *	AJAX Request Handler
	 */
	public function getReportBy() : Response {
		$this->viewBuilder()->setLayout('ajax');

		switch($this->request->getQuery('t')) {
			case '1PM':
				$dateStart = new DateTime($this->request->getQuery('m'));
				return $this->getReportByProgram($dateStart, $dateStart->endOfMonth());

			case '1PP':
				$dateStart = new DateTime($this->request->getQuery('y'));
				return $this->getReportByProgram($dateStart, $dateStart->addYears(1)->addDays(-1));
				
			case '1M':
				$this->prepareRequestedDatePeriod($this->request->getQuery('m'));
				$this->viewBuilder()->setTemplate('by_1m');
				return $this->getReportByPeriod();
				
			case '4M':
				$this->prepareRequestedDatePeriod($this->request->getQuery('m'));
				$this->viewBuilder()->setTemplate('by_4m');
				return $this->getReportByPeriod();
				
			default :
				return $this->render();
		}
	}
	
	/**
	 *	PDF Print Request Handler
	 */
	public function downloadReport() : Response {
		$this->viewBuilder()->setOption(
			'pdfConfig', [
				'download' => true,
				'orientation' => 'portrait',
				'pageSize' => 'Letter',
				'filename' => 'Reporte-'.$this->request->getQuery('t').'-'.$this->request->getQuery('m'),
				'margin' => [
					'bottom' => 10,
					'left' => 10,
					'right' => 10,
					'top' => 10,
			    ],
			]
		)
		->setLayout('reporte')
		->setClassName('CakePdf.Pdf');
		
		switch($this->request->getQuery('t')) {
			case '1PM':
				$dateStart = new DateTime($this->request->getQuery('m'));
				return $this->getReportByProgram($dateStart, $dateStart->endOfMonth());

			case '1PP':
				$dateStart = new DateTime($this->request->getQuery('y'));
				return $this->getReportByProgram($dateStart, $dateStart->addYears(1)->addDays(-1));
				
			case '1M':
				$this->prepareRequestedDatePeriod($this->request->getQuery('m'));
				$this->viewBuilder()->setTemplate('by_1m');
				return $this->getReportByPeriod();
				
			case '4M':
				$this->prepareRequestedDatePeriod($this->request->getQuery('m'));
				$this->viewBuilder()->setTemplate('by_4m');
				return $this->getReportByPeriod();
		}
	}
	/**
	 *	Reportes por Programa
	 */
	protected function getReportByProgram(DateTime $start, DateTime $end) : Response {
		$programa = $this->ProgramsRepository->get($this->request->getQuery('p'));
		$programa = $this->ProgramsRepository->loadInto($programa, ['ReportesProgramas' => function(SelectQuery $query) use($start, $end) {
			return $query->matching('ReportesCabinas', function(SelectQuery $query) use($start, $end) {
				return $query->matching('BitacoraCabina', function(SelectQuery $query) use($start, $end) {
					return $query->where(function(QueryExpression $exp) use($start, $end) {
						return $exp->between('fecha', $start, $end);
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
		
		$this->set(compact('programa', 'start', 'end', 'reportes', 'ocurrences', 'statusLongText'));
		$this->viewBuilder()->setTemplate('by_1p');
		
		return $this->render();
	}
	
	/**
	 *	Reportes por Mes / Cuatrimestre
	 */
	protected function getReportByPeriod() : Response {
		$reportStart = self::$reportStart;
		$reportEnd = self::$reportEnd;
		$reportesProgramas = $this->ProgramsRepository
								->ReportesProgramas
									->find()
										->contain('Programas', function(SelectQuery $query) {
											return $query->select(['ID', 'name']);
										})
										->matching('Programas', function(SelectQuery $query) {
											return $query->where(['Programas.reportable' => true]);
										})
										->matching('ReportesCabinas', function(SelectQuery $query) {
											return $query
													->select(['ID', 'bitacoraID'])
													->matching('BitacoraCabina', function(SelectQuery $query) {
														return $query
																->select(['ID', 'fecha'])
																->where(function(QueryExpression $exp) {
																	return $exp->between('fecha', self::$reportStart, self::$reportEnd);
																});
													});
										})
										->all();

		$reportesProgramas = $reportesProgramas->reject(function($rp) {
			return empty($rp->status);
		});
		$RPByStatus = $reportesProgramas->groupBy('status')->toArray();	
		$RPByStatus = [
			'V' => $RPByStatus['V'],
			'G' => $RPByStatus['G'],
			'S' => $RPByStatus['S'],
			'X' => $RPByStatus['X']
		];

		$XtoWord = NumberToWords::transformNumber('es', count($RPByStatus['X']));
		$statusLongText = ReportesPrograma::STATUS_LONGTEXT_FOR_1P;
		$programsCount = $this->ProgramsRepository->find()->count();

		$programas = $this->ProgramsRepository
							->find()
								->select(['ID', 'name'])
								->where(['reportable' => true])
								->orderAsc('name')
								->contain('ReportesProgramas', function(SelectQuery $query) {
									return $query
											->select(['ID', 'programaID', 'status'])
											->matching('ReportesCabinas', function(SelectQuery $query) {
												return $query
													->select(['ID', 'bitacoraID'])
													->matching('BitacoraCabina', function(SelectQuery $query) {
														return $query
																->select(['ID', 'fecha'])
																->where(function(QueryExpression $exp) {
																	return $exp->between('fecha', self::$reportStart, self::$reportEnd);
																});
													});
									});
								})
								->formatResults(function(CollectionInterface $results) {
									return $results->map(function ($programa) {
										$programa['reportes'] = (new Collection($programa['reportes']))
																		->reject(function($reporte) { return empty($reporte['status']); })
																			->groupBy('status')
																				->toArray();
										if(!isset($programa['reportes']['V'])) $programa['reportes']['V'] = [];
										if(!isset($programa['reportes']['G'])) $programa['reportes']['G'] = [];
										if(!isset($programa['reportes']['S'])) $programa['reportes']['S'] = [];
										if(!isset($programa['reportes']['X'])) $programa['reportes']['X'] = [];
										$programa['reportes'] = [
											'V' => $programa['reportes']['V'],
											'G' => $programa['reportes']['G'],
											'S' => $programa['reportes']['S'],
											'X' => $programa['reportes']['X']
										];
										$totalReports = count($programa['reportes']['V']) +
														count($programa['reportes']['G']) +
															count($programa['reportes']['S']) +
																count($programa['reportes']['X']);
										if((count($programa['reportes']['V']) + count($programa['reportes']['G'])  + count($programa['reportes']['S'])) == 0) {
											$programa['chart']['Cumplimiento'] = 0; 
										} else {
											$programa['chart']['Cumplimiento'] = (count($programa['reportes']['V']) + count($programa['reportes']['G'])  + count($programa['reportes']['S'])) / $totalReports;
										}
										$programa['chart']['Incumplimiento'] = count($programa['reportes']['X']) > 0 ? count($programa['reportes']['X']) / $totalReports : 0;
										
										return $programa;
									});
								})
								->disableHydration()
								->all();
		
		$reportesCR = $this->ProgramsRepository
								->ReportesProgramas
									->ReportesCabinas
									->find()
										->select(['ID', 'controles', 'reporte'])
										->where(function(QueryExpression $exp, SelectQuery $q) {
											return $exp->gt('controles', 0);
										})
										->matching('BitacoraCabina', function(SelectQuery $query) {
											return $query
													->select(['ID', 'fecha'])
													->where(function(QueryExpression $exp) {
														return $exp->between('fecha', self::$reportStart, self::$reportEnd);
													});
										})
										->all();
		$crs = [];
		foreach($reportesCR as $cr) {
			$cs = explode("\n", $cr->reporte);
			foreach($cs as $c) {
				if($c == "\n" || $c == '' || empty($c)) continue;
				$crs[] = ['cr' => strtoupper(preg_replace('/^-/', '', trim($c))), 'fecha' => $cr->_matchingData['BitacoraCabina']->fecha->toUnixString()];
			}
		}
		
		$crDateValues = array_column($crs, 'fecha'); 
		array_multisort($crDateValues, SORT_ASC, $crs);
		
		$printBarColors = ['thisIsOnlyAStartingPointer', 'green', 'orange', 'blue', 'red'];
		
		$this->set(compact('reportStart', 'reportEnd', 'reportesProgramas', 'RPByStatus', 'XtoWord', 'programsCount', 'statusLongText', 'programas', 'reportesCR', 'crs', 'printBarColors'));

		return $this->render();
	}

	protected function prepareRequestedDatePeriod(string $period) : void {
		try {
			self::$reportStart = (new DateTime($period))->startOfMonth();
			self::$reportEnd = (new DateTime($period))->endOfMonth();
		}
		catch(\DateMalformedStringException $e) {
			$period = preg_split("/-/", $period);
			self::$reportStart = match($period[1]) {
				'C1' => DateTime::createFromFormat('Y-m', $period[0] .'-01')->startOfMonth(),
				'C2' => DateTime::createFromFormat('Y-m', $period[0] .'-05')->startOfMonth(),
				'C3' => DateTime::createFromFormat('Y-m', $period[0] .'-09')->startOfMonth(),
			};
			self::$reportEnd = match($period[1]) {
				'C1' => DateTime::createFromFormat('Y-m', $period[0] .'-04')->endOfMonth(),
				'C2' => DateTime::createFromFormat('Y-m', $period[0] .'-08')->endOfMonth(),
				'C3' => DateTime::createFromFormat('Y-m', $period[0] .'-12')->endOfMonth(),
			};
		}
	}
	
	protected function setViewVars() : void {
		$programas = $this->ProgramsRepository
							->find('list')
								->orderAsc('name')
								->all();
		$end = DateTime::now();
		$start = new DateTime(self::REPORTING_START_DATE);
		$mInterval = DateTime::createInterval(months: 1);
		$mPeriod = new \DatePeriod($start, $mInterval, $end, \DatePeriod::INCLUDE_END_DATE);
		$meses = [];
		$cuatrimestres = [];
		foreach ($mPeriod as $date) {
			$meses[$date->format('Y-m')] = (new DateTime($date))->i18nFormat("MMMM 'de' YYYY");
			$m = DateTime::createFromFormat(\DateTimeInterface::RSS, $date->format(\DateTimeInterface::RSS));
			if($m->month >= 1 && $m->month <= 4) {
				$cuatrimestres[$m->format('Y')][$m->format('Y-C1')] = $m->format('Y').' 4T1 / Enero - Abril';
			}
			if($m->month >= 5 && $m->month <= 8) {
				$cuatrimestres[$m->format('Y')][$m->format('Y-C2')] = $m->format('Y').' 4T2 / Mayo - Agosto';
			}
			if($m->month >= 9 && $m->month <= 12) {
				$cuatrimestres[$m->format('Y')][$m->format('Y-C3')] = $m->format('Y').' 4T3 / Septiembre - Diciembre';
			}
		}

		krsort($cuatrimestres, SORT_NUMERIC);foreach($cuatrimestres as $i => $c){krsort($cuatrimestres[$i], SORT_NATURAL);}
		krsort($meses, SORT_NATURAL);
		
		$start = new DateTime(self::YR_PERIOD_START_DATE);
		$mInterval = DateTime::createInterval(years: 1);
		$mPeriod = new \DatePeriod($start, $mInterval, $end, \DatePeriod::INCLUDE_END_DATE);
		$periodos = [];
		foreach ($mPeriod as $date) {
			$d = new DateTime($date);
			$endDate = $d->addYears(1)->lessThanOrEquals($end)? $d->addYears(1)->addDays(-1)->i18nFormat("d 'de' MMMM 'de' YYYY") : 'este día';
			$periodos[$d->toUnixString()] = $d->i18nFormat("d 'de' MMMM 'de' YYYY") .' a '. $endDate;
		}
		krsort($periodos, SORT_NATURAL);
		
		$this->set(compact('programas', 'meses', 'cuatrimestres', 'periodos'));
	}

	public function index() {
		$query = $this->ReportesCabinas->find()->orderDesc('bitacoraID')->orderAsc('horaInicio');
		$reportesCabinas = $this->paginate($query);
		$this->set(compact('reportesCabinas'));
	}

    public function view($id = null) {
        $reporte = $this->ReportesCabinas->get($id, contain: ['Locutores', 'ReportesProgramas', 'ReportesProgramas.Programas', 'BitacoraCabina']);
        $this->set(compact('reporte'));
    }

	public function edit($id = null) {
		//$max
		$reporte = $this->ReportesCabinas->get($id, contain: [/*'BitacoraCabina', 'Locutores'*/]);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$reporte = $this->ReportesCabinas->patchEntity($reporte, $this->request->getData());
			if ($this->ReportesCabinas->save($reporte)) {
				$this->Flash->success(__('The reportes cabina has been saved.'));

			    return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('The reportes cabina could not be saved. Please, try again.'));
		}
		$locutores = $this->ReportesCabinas->Locutores->find('list')->all();
		$bitacoras = $this->ReportesCabinas->BitacoraCabina->find('list')
															->where(function (QueryExpression $exp, SelectQuery $q) use($reporte) {
																return $exp->between('BitacoraCabina.ID', $reporte->bitacoraID - 100, $reporte->bitacoraID + 100);
															})
															->limit(200)
															->all();
		$this->set(compact('reporte', 'locutores', 'bitacoras'));
	}

    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $reportesCabina = $this->ReportesCabinas->get($id);
        if ($this->ReportesCabinas->delete($reportesCabina)) {
            $this->Flash->success(__('The reportes cabina has been deleted.'));
        } else {
            $this->Flash->error(__('The reportes cabina could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }
}
