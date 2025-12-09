<?php
declare(strict_types=1);

namespace SPC\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * DiasProgramasFixture
 */
class DiasProgramasFixture extends TestFixture
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
                'programa_id' => 1,
            ],
        ];
        parent::init();
    }
}

