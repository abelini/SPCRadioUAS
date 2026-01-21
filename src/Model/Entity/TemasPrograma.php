<?php
declare(strict_types=1);

namespace SPC\Model\Entity;

use Cake\ORM\Entity;


class TemasPrograma extends Entity implements \Stringable
{
    protected array $_accessible = [
        'ProgramaID' => true,
        'tema' => true,
        'invitados' => true,
        'tags' => true,
        'created' => true,
        'modified' => true,
        'programa' => true,
    ];

    public function __toString(): string
    {
        return $this->get('tema');
    }
}
