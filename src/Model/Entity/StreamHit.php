<?php
declare(strict_types=1);

namespace SPC\Model\Entity;

use Cake\ORM\Entity;

/**
 * StreamHit Entity
 *
 * @property int $ID
 * @property string $format
 * @property string $referer
 * @property string $refererType
 * @property string $ip
 * @property string $userAgent
 * @property string $country
 * @property string $countryCode
 * @property string $city
 * @property string $zip
 * @property string|null $lat
 * @property string|null $lon
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 */
class StreamHit extends Entity
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
