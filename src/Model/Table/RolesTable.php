<?php
declare(strict_types=1);

namespace SPC\Model\Table;

use SPC\Model\Entity\Rol;
use Cake\I18n\Date;
use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Collection\Collection;


class RolesTable extends Table
{

	public function initialize(array $config): void
	{
		parent::initialize($config);

		$this->setTable('roles');

		$this->setDisplayField('fechaInicio')
			->setPrimaryKey('ID')
			->setEntityClass('Rol');

		$this->belongsTo('Turnos', [
			'foreignKey' => 'turnoID',
			'joinType' => 'INNER',
		]);

		$this->hasMany('Asignaciones', [
			'sort' => [
				'diaID' => 'ASC',
				'horarioID' => 'ASC'
			]
		])
			->setForeignKey('rolID')
			->setDependent(true);
	}

	/**
	 * Returns the active rol for a given date, with asignaciones filtered
	 * to that specific day, including locutores, horarios, and the day's programas.
	 * Also slices each asignacion's programas to only those within their shift,
	 * except for the last locutor who gets all programs from their start time onward.
	 */
	public function findForDay(SelectQuery $query, Date $date): SelectQuery
	{
		return $query
			->where(['fechaInicio' => $date->startOfWeek()])
			->contain('Asignaciones', function (SelectQuery $q) use ($date) {
				return $q->where(['diaID' => $date->dayOfWeek])->orderByAsc('horaInicio');
			})
			->contain('Asignaciones.Locutores', function (SelectQuery $q) {
				return $q->select(['ID', 'name', 'photo']);
			})
			->contain('Asignaciones.Horarios', function (SelectQuery $q) {
				return $q->select(['ID', 'horaInicio', 'horaFin', 'turnoID']);
			})
			->contain('Asignaciones.Dias.Programas', function (SelectQuery $q) {
				return $q->where(['Programas.outOfAir' => false])->orderByAsc('horaInicio');
			})
			->formatResults(function ($results) {
				return $results->map(function (?Rol $rol) {
					if ($rol === null) {
						return $rol;
					}
					$asignaciones = $rol->asignaciones;
					$lastKey = array_key_last($asignaciones);

					foreach ($asignaciones as $key => $asignacion) {
						$programas = new Collection($asignacion->dia->programas);
						$isLast = ($key === $lastKey);

						$filtered = $programas
							->filter(function ($programa) use ($asignacion, $isLast) {
								$startsAfterShiftBegins = $programa->horaInicio >= $asignacion->horario->horaInicio;
								// Last locutor gets all programs from their start time onward
								$withinShift = $isLast || $programa->horaInicio < $asignacion->horario->horaFin;
								return $startsAfterShiftBegins && $withinShift;
							})
							->reject(fn($programa) => !$programa->isReportable());

						$rol->asignaciones[$key]->dia->programas = $filtered->toArray();
					}
					return $rol;
				});
			});
	}

	public function findPrevious(SelectQuery $query, Rol $rol)
	{
		return $query->where(['fechaFin' => $rol->fechaInicio->addDays(-1)]);
	}

	public function findNext(SelectQuery $query, Rol $rol)
	{
		return $query->where(['fechaInicio' => $rol->fechaFin->addDays(1)]);
	}

	public function validationDefault(Validator $validator): Validator
	{
		$validator
			->date('fechaInicio')
			->requirePresence('fechaInicio', 'create')
			->notEmptyDate('fechaInicio');

		$validator
			->date('fechaFin')
			->requirePresence('fechaFin', 'create')
			->notEmptyDate('fechaFin');

		$validator
			->integer('turnoID')
			->notEmptyString('turnoID');

		return $validator;
	}

	public function buildRules(RulesChecker $rules): RulesChecker
	{
		$rules->add($rules->existsIn(['turnoID'], 'Turnos'), ['errorField' => 'turnoID']);
		return $rules;
	}
}