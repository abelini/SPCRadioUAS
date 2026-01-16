<?php
declare(strict_types=1);

namespace SPC\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TemasProgramasFixture
 */
class TemasProgramasFixture extends TestFixture
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
                'ProgramaID' => 1,
                'tema' => 'Lorem ipsum dolor sit amet',
                'invitados' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
