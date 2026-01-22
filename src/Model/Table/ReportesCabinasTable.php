<?php
declare(strict_types=1);

namespace SPC\Model\Table;

use Cake\Event\EventInterface;
use Cake\ORM\Entity;
use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;


class ReportesCabinasTable extends Table
{

    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('reportes_cabinas');
        $this->setDisplayField('ID');
        $this->setPrimaryKey('ID');

        $this->addBehavior('Timestamp');

        $this->hasMany('ReportesProgramas')->setForeignKey('ReporteCabinaID')->setDependent(true);

        $this->belongsTo('Locutores')->setForeignKey('locutorID')->setProperty('locutor');

        $this->belongsTo('BitacoraCabina')->setForeignKey('bitacoraID')->setProperty('bitacora');
    }

    protected function findAllAssociatedData(SelectQuery $query): SelectQuery
    {
        return $query
            ->contain('BitacoraCabina')
            ->contain('Locutores', function (SelectQuery $q) {
                return $q->select(['ID', 'name'], true);
            });
    }

    /**
     * Finder para encontrar 'ReportesCabinas' que apuntan a una 'BitacoraCabina' que no existe.
     */
    public function findOrphans(SelectQuery $query, array $options = []): SelectQuery
    {
        return $query->where(['ReportesCabinas.bitacoraID IS NOT' => null])
            ->leftJoinWith('BitacoraCabina')
            ->where(['BitacoraCabina.ID IS' => null]);
    }

    /*
    public function afterMarshal(EventInterface $event, Entity $reporte, \ArrayObject $data, \ArrayObject $options) {
        if (empty(trim($reporte->reporte))) {
            $reporte->set('reporte', 'Sin novedad');
        }
    }*/

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('bitacoraID')
            ->requirePresence('bitacoraID', 'create')
            ->notEmptyString('bitacoraID');

        $validator
            ->integer('locutorID')
            ->requirePresence('locutorID', 'create')
            ->notEmptyString('locutorID');
        /*
        $validator
            ->time('horaInicio')
            ->requirePresence('horaInicio', 'create')
            ->notEmptyTime('horaInicio');

        $validator
            ->time('horaFin')
            ->requirePresence('horaFin', 'create')
            ->notEmptyTime('horaFin');
        */
        $validator
            ->scalar('reporte')
            ->allowEmptyString('reporte');

        $validator
            ->integer('controles')
            ->notEmptyString('controles');

        return $validator;
    }
}

