<?php
declare(strict_types=1);

namespace SPC\Controller;

use SPC\Model\Entity\Rol;
use Cake\Collection\Collection;
use Cake\Event\EventInterface;
use Cake\Http\Response;
use Cake\I18n\DateTime;
use Cake\ORM\Query\SelectQuery;
use CakePdf\View\Pdfiew;

class RolesController extends AppController
{

	public function beforeFilter(EventInterface $event)
	{
		parent::beforeFilter($event);
		$this->Authentication->allowUnauthenticated(['index', 'view', 'download']);
	}

	public function index(): Response
	{
		return $this->redirect(['action' => 'view']);
	}

	public function view(): Response
	{
		$rol = $this->getRequestedRol();
		$weekStart = clone $rol->fechaInicio;
		$asignaciones = (new Collection($rol->asignaciones))
			->groupBy(fn($a) => (clone $weekStart)->addDays($a->diaID - 1)->toDateString())
			->toArray();

		ksort($asignaciones);

		$this->set(compact('rol', 'asignaciones'));

		if ($this->request->getQuery('action') == 'download') {
			return $this->download($rol, $asignaciones);
		}
		return $this->render();
	}

	public function download(Rol $rol, array $asignaciones): Response
	{
		$this->viewBuilder()->setOption(
			'pdfConfig',
			[
				'download' => true,
				'orientation' => 'portrait',
				'pageSize' => 'A4',//'Legal',
				'filename' => 'Rol-' . $rol->ID,
				'margin' => [
					'bottom' => 10,
					'left' => 10,
					'right' => 10,
					'top' => 5,
				],
			]
		)
			->setClassName('CakePdf.Pdf');

		return $this->render();
	}


	protected function getRequestedRol(): Rol
	{
		if ($this->request->getQuery('rol') !== null) {
			return $this->Roles->get(
				$this->request->getQuery('rol'),
				contain: [
					'Asignaciones' => function (SelectQuery $query) {
						return $query->contain([
							'Locutores' => function (SelectQuery $query) {
								return $query->select(['ID', 'name']);
							},
							'Horarios',
							'Dias'
						]);
					}
				],
			);
		}
		$today = DateTime::now();
		$lastMonday = $today->isMonday() ? $today : $today->startOfWeek();

		return $this->Roles
			->find()
			->where(['fechaInicio' => $lastMonday])
			->contain('Asignaciones', function (SelectQuery $query) {
				return $query->contain([
					'Locutores' => function (SelectQuery $query) {
						return $query->select(['ID', 'name']);
					},
					'Horarios',
					'Dias'
				]);
			})
			->first();
	}

	public function beforeRender(EventInterface $event)
	{
		$this->viewBuilder()->setLayout('cabina');
	}
}