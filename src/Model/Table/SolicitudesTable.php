<?php
declare(strict_types=1);

namespace SPC\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class SolicitudesTable extends Table
{

    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('solicitudes');
        $this->setDisplayField('solicitante');
        $this->setEntityClass('Solicitud');
        $this->setPrimaryKey('ID');

        $this->addBehavior('Timestamp');

        $this->belongsTo('TipoSolicitud')
            ->setForeignKey('tipoSolicitudID')
            ->setProperty('tipoSolicitud');

        $this->belongsTo('PrimerAsignado')
            ->setForeignKey('primerAsignadoID')
            ->setProperty('primerAsignado');

        $this->belongsTo('SegundoAsignado')
            ->setForeignKey('segundoAsignadoID')
            ->setProperty('segundoAsignado');

        $this->belongsTo('Autorizante')
            ->setForeignKey('autorizanteID')
            ->setclassName('Autorizante')
            ->setProperty('autorizante');

        $this->belongsTo('ProductorTecnico')
            ->setForeignKey('productorID')
            ->setProperty('productorTecnico');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('tipoID')
            ->notEmptyString('tipoID');

        $validator
            ->scalar('solicitante')
            ->maxLength('solicitante', 255)
            ->notEmptyString('solicitante');

        $validator
            ->scalar('evento')
            ->requirePresence('evento', 'create')
            ->notEmptyString('evento');

        $validator
            ->scalar('observaciones')
            ->allowEmptyString('observaciones');

        $validator
            ->datetime('fecha')
            ->requirePresence('fecha', 'create')
            ->notEmptyDate('fecha');


        $validator
            ->integer('primerAsignado')
            ->allowEmptyString('primerAsignado');

        $validator
            ->integer('segundoAsignado')
            ->allowEmptyString('segundoAsignado');

        $validator
            ->integer('autorizanteID')
            ->allowEmptyString('autorizanteID');

        $validator
            ->integer('productorID')
            ->allowEmptyString('productorID');



        return $validator;
    }
}

