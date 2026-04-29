<?php
declare(strict_types=1);

namespace SPC\Model\Entity;

use Cake\ORM\Entity;

/**
 * StreamHit Entity
 *
 * @property int $ID
 * @property string|null $format
 * @property string|null $referer
 * @property string|null $refererType
 * @property string|null $ip
 * @property string|null $userAgent
 * @property string|null $country
 * @property string|null $countryCode
 * @property string|null $city
 * @property string|null $zip
 * @property float|null $lat
 * @property float|null $lon
 * @property \Cake\I18n\DateTime $created_at
 */
class StreamHit extends Entity
{
    protected $_accessible = [
        '*' => true,
        'ID' => false,
    ];
}