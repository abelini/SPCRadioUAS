<?php
declare(strict_types=1);

namespace SPC\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SegundoAsignadoFixture
 */
class SegundoAsignadoFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'usuarios';
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
                'empleado' => 1,
                'username' => 'Lorem ipsum dolor sit amet',
                'password' => 'Lorem ipsum dolor sit amet',
                'name' => 'Lorem ipsum dolor sit amet',
                'fullname' => 'Lorem ipsum dolor sit amet',
                'email' => 'Lorem ipsum dolor sit amet',
                'base' => 1,
            ],
        ];
        parent::init();
    }
}

