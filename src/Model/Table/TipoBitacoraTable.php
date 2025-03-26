<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class TipoBitacoraTable extends Table {

	public function initialize(array $config): void {
		parent::initialize($config);

		$this->setTable('tipo_bitacora');
		$this->setDisplayField('name');
		$this->setPrimaryKey('ID');
	}
}
