<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * BitacoraVigilanciaFixture
 */
class BitacoraVigilanciaFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'bitacora_vigilancia';
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
                'vigilanteID' => 1,
                'tipoBitacora' => 1,
                'fecha' => '2024-03-15',
                'observaciones' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'created' => '2024-03-15 12:31:19',
                'modified' => '2024-03-15 12:31:19',
            ],
        ];
        parent::init();
    }
}
