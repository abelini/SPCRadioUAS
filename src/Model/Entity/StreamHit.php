<?php
declare(strict_types=1);

namespace SPC\Model\Entity;

use Cake\ORM\Entity;


class StreamHit extends Entity
{
    protected array $_accessible = [
        'ID' => true,
        'format' => true,
        'referer' => true,
        'refererType' => true,
        'ip' => true,
        'userAgent' => true,
        'country' => true,
        'countryCode' => true,
        'city' => true,
        'zip' => true,
        'lat' => true,
        'lon' => true,
        'created' => true,
        'modified' => true,
    ];
}
