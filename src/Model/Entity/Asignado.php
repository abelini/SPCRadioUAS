<?php
declare(strict_types=1);

namespace SPC\Model\Entity;

use Cake\ORM\Entity;

/**
 * Asignado Entity
 *
 * @property int $id
 * @property int $empleado
 * @property string $username
 * @property string $password
 * @property string $name
 * @property string $fullname
 * @property string $email
 * @property bool $base
 *
 * @property \App\Model\Entity\Mensaje[] $mensajes
 * @property \App\Model\Entity\ReportesCabina[] $reportes_cabinas
 * @property \App\Model\Entity\Solicitude[] $solicitudes
 * @property \App\Model\Entity\Tweet[] $tweets
 * @property \App\Model\Entity\Permiso[] $permisos
 */
class Asignado extends Entity
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
        'empleado' => true,
        'username' => true,
        'password' => true,
        'name' => true,
        'fullname' => true,
        'email' => true,
        'base' => true,
        'mensajes' => true,
        'reportes_cabinas' => true,
        'solicitudes' => true,
        'tweets' => true,
        'permisos' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array<string>
     */
    protected array $_hidden = [
        'password',
    ];
}

