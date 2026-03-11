<?php
declare(strict_types=1);

namespace SPC\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\EventInterface;
use Cake\Datasource\EntityInterface;
use ArrayObject;
use SPC\Model\Entity\ReportesPrograma;


class ReportesProgramasTable extends Table
{

	public function initialize(array $config): void
	{
		parent::initialize($config);

		$this->setTable('reportes_programas');
		$this->setDisplayField('ID');
		$this->setPrimaryKey('ID');

		$this->belongsTo('ReportesCabinas')
			->setForeignKey('ReporteCabinaID')
			->setProperty('reporte');

		$this->belongsTo('Programas')
			->setForeignKey('programaID');
	}

	/**
	 * Normaliza el status vacío o null a 'V' (en vivo) antes de persistir.
	 */
	public function beforeMarshal(EventInterface $event, ArrayObject $data, ArrayObject $options): void
	{
		if (empty($data['status'])) {
			$data['status'] = ReportesPrograma::DEFAULT_STATUS;
		}
	}

	public function findOrphans(SelectQuery $query, array $options = []): SelectQuery
	{
		return $query->where(['ReportesProgramas.ReporteCabinaID IS NOT' => null])
			->leftJoinWith('ReportesCabinas')
			->where(['ReportesCabinas.ID IS' => null]);
	}

	public function validationDefault(Validator $validator): Validator
	{
		$validator
			->integer('ReporteCabinaID')
			->notEmptyString('ReporteCabinaID');

		$validator
			->integer('programaID')
			->notEmptyString('programaID');

		$validator
			->scalar('status')
			->allowEmptyString('status');

		return $validator;
	}

	public function buildRules(RulesChecker $rules): RulesChecker
	{
		$rules->add($rules->existsIn(['ReporteCabinaID'], 'ReportesCabinas'), ['errorField' => 'ReporteCabinaID']);
		$rules->add($rules->existsIn(['programaID'], 'Programas'), ['errorField' => 'programaID']);

		return $rules;
	}
}

