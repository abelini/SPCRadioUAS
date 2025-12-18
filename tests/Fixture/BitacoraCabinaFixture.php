<?php
declare(strict_types=1);

namespace SPC\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * BitacoraCabinaFixture
 */
class BitacoraCabinaFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'bitacora_cabina';
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
                'fecha' => '2024-02-20',
                'created' => '2024-02-20 13:18:31',
                'modified' => '2024-02-20 13:18:31',
            ],
        ];
        parent::init();
    }
}

