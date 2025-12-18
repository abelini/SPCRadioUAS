<?php
declare(strict_types=1);

namespace SPC\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ReportesVigilanciaFixture
 */
class ReportesVigilanciaFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'reportes_vigilancia';
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
                'bitacoraID' => 1,
                'fire' => 1,
                'moist' => 1,
                'ventilation' => 1,
                'locks' => 1,
                'blackout' => 1,
                'lost_signal' => 1,
                'alarm_on' => 1,
                'leds' => 1,
                'burning_smell' => 1,
                'invaded' => 1,
                'walls_cracked' => 1,
                'antenna_bent' => 1,
                'antenna_lights_off' => 1,
                'antenna_anchor_bent' => 1,
                'blackout_duration' => 1,
                'lost_signal_duration' => 1,
            ],
        ];
        parent::init();
    }
}

