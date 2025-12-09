<?php
declare(strict_types=1);

namespace SPC\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * DiasHorariosFixture
 */
class DiasHorariosFixture extends TestFixture
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
                'dia_id' => 1,
                'horario_id' => 1,
            ],
        ];
        parent::init();
    }
}

