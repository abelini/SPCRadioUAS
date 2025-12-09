<?php
declare(strict_types=1);

namespace SPC\Model\Entity;

use Cake\ORM\Entity;

/**
 * DiasHorario Entity
 *
 * @property int $id
 * @property int $dia_id
 * @property int $horario_id
 *
 * @property \App\Model\Entity\Dia $dia
 * @property \App\Model\Entity\Horario $horario
 */
class DiasHorario extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'dia_id' => true,
        'horario_id' => true,
        'dia' => true,
        'horario' => true,
    ];
}

