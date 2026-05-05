<?php
declare(strict_types=1);

namespace SPC\Model\Entity;

use Cake\ORM\Entity;

/**
 * CategoriasPrograma Entity
 *
 * @property int $ID
 * @property string $name
 * @property string $slug
 * @property string $icon
 */
class CategoriasPrograma extends Entity
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
        'name' => true,
        'slug' => true,
        'icon' => true,
    ];
}
