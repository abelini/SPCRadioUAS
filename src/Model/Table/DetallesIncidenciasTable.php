<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class DetallesIncidenciasTable extends Table {

	public function initialize(array $config): void {
		parent::initialize($config);

		$this->setTable('detalles_incidencias');
		$this->setDisplayField('ID');
		$this->setPrimaryKey('ID');
		$this->setEntityClass('DetalleIncidencia');
		
		$this->belongsTo('Incidencias')->setForeignKey('incidenciaID');
    }

    public function validationDefault(Validator $validator): Validator {

        $validator
            ->boolean('fire')
            ->allowEmptyString('fire');

        $validator
            ->boolean('moist')
            ->allowEmptyString('moist');

        $validator
            ->boolean('ventilation')
            ->allowEmptyString('ventilation');

        $validator
            ->boolean('locks')
            ->allowEmptyString('locks');

        $validator
            ->boolean('blackout')
            ->allowEmptyString('blackout');

        $validator
            ->boolean('lost_signal')
            ->allowEmptyString('lost_signal');

        $validator
            ->boolean('alarm_on')
            ->allowEmptyString('alarm_on');

        $validator
            ->boolean('leds')
            ->allowEmptyString('leds');

        $validator
            ->boolean('burning_smell')
            ->allowEmptyString('burning_smell');

        $validator
            ->boolean('invaded')
            ->allowEmptyString('invaded');

        $validator
            ->boolean('walls_cracked')
            ->allowEmptyString('walls_cracked');

        $validator
            ->boolean('antenna_bent')
            ->allowEmptyString('antenna_bent');

        $validator
            ->boolean('antenna_lights_off')
            ->allowEmptyString('antenna_lights_off');

        $validator
            ->boolean('antenna_anchor_bent')
            ->allowEmptyString('antenna_anchor_bent');

        $validator
            ->integer('blackout_duration');
           // ->allowEmptyString('blackout_duration');

        $validator
            ->integer('lost_signal_duration');
           // ->allowEmptyString('lost_signal_duration');

        return $validator;
    }
}
