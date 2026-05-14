<?php
declare(strict_types=1);

namespace SPC\Model\Table;

use Cake\Database\Expression\QueryExpression;
use Cake\ORM\Query\SelectQuery;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use SPC\Model\Entity\Solicitud;
use SPC\Model\Entity\TipoSolicitud;


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

    public function findStats(SelectQuery $query, array $options): SelectQuery
    {
        return $query
            ->select([
                'Total' => $query->func()->count('*'),
                'Oldest' => $query->func()->min('fecha', ['date']),
                'Newest' => $query->func()->max('fecha', ['date']),
                'TotalGDS' => $query->func()->count(
                    $query->expr()
                        ->case()
                        ->when(['tipoSolicitudID' => TipoSolicitud::SPOT_RECORDING])
                        ->then(1)
                ),
                'TotalMDC' => $query->func()->count(
                    $query->expr()
                        ->case()
                        ->when(['tipoSolicitudID' => TipoSolicitud::CEREMONY_MASTER])
                        ->then(1)
                ),
                'TotalCR' => $query->func()->count(
                    $query->expr()
                        ->case()
                        ->when(['tipoSolicitudID' => TipoSolicitud::REMOTE_BROADCAST])
                        ->then(1)
                )
            ])
            ->disableHydration();
    }

    public function findPending(SelectQuery $query): SelectQuery
    {
        return $query
            ->select([
                'UnrecordedSpots' => $query->func()->count(
                    $query->expr()
                        ->case()
                        ->when([
                            'tipoSolicitudID' => TipoSolicitud::SPOT_RECORDING,
                            'status' => Solicitud::NOT_STARTED,
                        ])
                        ->then(1)
                ),
                'UnnacceptedCeremonyMasters' => $query->func()->count(
                    $query->expr()
                        ->case()
                        ->when([
                            'tipoSolicitudID' => TipoSolicitud::CEREMONY_MASTER,
                            'aceptado' => Solicitud::UNACCEPTED,
                        ])
                        ->then(1)
                ),
            ])
            ->disableHydration();
    }

    public function findSearch(SelectQuery $query, array $options): SelectQuery
    {
        $q = $options['q'] ?? '';
        return $query
            ->contain(['TipoSolicitud', 'PrimerAsignado', 'SegundoAsignado', 'Autorizante', 'ProductorTecnico'])
            ->where(fn(QueryExpression $exp) => $exp->or([
                'Solicitudes.solicitante LIKE' => '%' . $q . '%',
                'Solicitudes.evento LIKE' => '%' . $q . '%',
            ]))
            ->orderByDesc('Solicitudes.fecha');
    }

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

