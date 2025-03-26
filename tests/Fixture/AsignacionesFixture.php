<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AsignacionesFixture
 */
class AsignacionesFixture extends TestFixture
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
                'rol_id' => 1,
                'usuario_id' => 1,
                'dia_id' => 1,
                'horario_id' => 1,
            ],
        ];
        parent::init();
    }
}
