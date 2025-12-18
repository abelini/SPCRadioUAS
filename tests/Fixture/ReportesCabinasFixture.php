<?php
declare(strict_types=1);

namespace SPC\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ReportesCabinasFixture
 */
class ReportesCabinasFixture extends TestFixture
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
                'bitacora_id' => 1,
                'locutor_id' => 1,
                'hora_inicio' => '13:17:52',
                'hora_fin' => '13:17:52',
                'reporte' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'controles' => 1,
                'created' => '2024-02-20 13:17:52',
                'modified' => '2024-02-20 13:17:52',
            ],
        ];
        parent::init();
    }
}

