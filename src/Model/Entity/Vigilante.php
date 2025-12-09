<?php
declare(strict_types=1);

namespace SPC\Model\Entity;

use Cake\ORM\Entity;

/**
 * Vigilante Entity
 *
 * @property int $ID
 * @property int $empleado
 * @property string $username
 * @property string $password
 * @property string $name
 * @property string $fullname
 * @property string $email
 * @property bool $base
 * @property string $photo
 *
 * @property \App\Model\Entity\Permiso[] $permisos
 */
class Vigilante extends Entity
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
        'photo' => true,
        'permisos' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var list<string>
     */
    protected array $_hidden = [
        'password',
    ];
}

