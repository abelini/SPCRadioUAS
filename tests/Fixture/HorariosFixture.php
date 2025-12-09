<?php
declare(strict_types=1);

namespace SPC\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * HorariosFixture
 */
class HorariosFixture extends TestFixture
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
                'id' => 1,
                'hora_inicio' => '12:50:23',
                'hora_fin' => '12:50:23',
                'turno_id' => 1,
            ],
        ];
        parent::init();
    }
}

