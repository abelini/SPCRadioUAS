<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProgramasFixture
 */
class ProgramasFixture extends TestFixture
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
                'name' => 'Lorem ipsum dolor sit amet',
                'hora_inicio' => '13:19:52',
                'hora_fin' => '13:19:52',
                'produccion' => 'Lorem ipsum dolor sit amet',
                'uo' => 1,
            ],
        ];
        parent::init();
    }
}
