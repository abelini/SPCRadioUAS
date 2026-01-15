<?php
declare(strict_types=1);

namespace SPC\Model\Entity;

use Cake\ORM\Entity;

/**
 * TemasPrograma Entity
 *
 * @property int $ID
 * @property int $ProgramaID
 * @property string $tema
 */
class TemasPrograma extends Entity implements \Stringable
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
        'ProgramaID' => true,
        'tema' => true,
    ];

    public function __toString(): string
    {
        return $this->tema;
    }
}
