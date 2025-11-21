<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PermisosFixture
 */
class PermisosFixture extends TestFixture
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
                'name' => 'Lorem ipsum dolor sit amet',
                'plural' => 'Lorem ipsum dolor sit amet',
                'singular' => 'Lorem ipsum dolor sit amet',
                'icon' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
