<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TipoSolicitudFixture
 */
class TipoSolicitudFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'tipo_solicitud';
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
                'name' => 'Lorem ipsum dolor sit amet',
                'imagen' => 'Lorem ipsum dolor sit amet',
                'icon' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
