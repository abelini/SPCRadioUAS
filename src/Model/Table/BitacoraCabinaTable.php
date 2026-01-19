<?php
declare(strict_types=1);

namespace SPC\Model\Table;

use SPC\Model\Entity\BitacoraCabina;
use Cake\ORM\Query\SelectQuery;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class BitacoraCabinaTable extends Table
{

	public function initialize(array $config): void
	{
		parent::initialize($config);

		$this->setTable('bitacora_cabina');
		$this->setDisplayField('fecha');
		$this->setPrimaryKey('ID');

		$this->addBehavior('Timestamp');

		$this->hasMany('ReportesCabinas')
			->setForeignKey('bitacoraID')
			->setProperty('reportes')
			->setDependent(true);
	}

	public function findPrevious(SelectQuery $query, BitacoraCabina $b)
	{
		return $query->where(['fecha' => $b->fecha->addDays(-1)]);
	}

	public function findNext(SelectQuery $query, BitacoraCabina $b)
	{
		return $query->where(['fecha' => $b->fecha->addDays(1)]);
	}

	#[\Override]
	public function findList(SelectQuery $query, \Closure|array|string|null $keyField = null, \Closure|array|string|null $valueField = null, \Closure|array|string|null $g = null, string $s = ';'): SelectQuery
	{
		$finder = $query->select(['ID', 'fecha'])->limit(60)->orderDesc('fecha');
		return parent::findList($finder, keyField: 'ID', valueField: function ($bitacora) {
			return 'Bitácora #' . $bitacora->ID . ' - ' . $bitacora->fecha->i18nFormat(\IntlDateFormatter::FULL);
		});
	}

	public function validationDefault(Validator $validator): Validator
	{
		$validator
			->date('fecha')
			->requirePresence('fecha', 'create')
			->notEmptyDate('fecha');

		return $validator;
	}
}

