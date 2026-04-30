<?php
declare(strict_types=1);

namespace SPC\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * StreamHitsFixture
 */
class StreamHitsFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'ID' => 1,
                'format' => 'Lorem ipsum dolor sit amet',
                'referer' => 'Lorem ipsum dolor sit amet',
                'refererType' => 'Lorem ipsum dolor sit amet',
                'ip' => 'Lorem ipsum dolor sit amet',
                'userAgent' => 'Lorem ipsum dolor sit amet',
                'country' => 'Lorem ipsum dolor sit amet',
                'countryCode' => 'Lo',
                'city' => 'Lorem ipsum dolor sit amet',
                'zip' => 'Lorem ip',
                'lat' => 1.5,
                'lon' => 1.5,
                'created' => '2026-04-29 17:45:21',
                'modified' => '2026-04-29 17:45:21',
            ],
        ];
        parent::init();
    }
}
