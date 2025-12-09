<?php
declare(strict_types=1);

namespace SPC\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TicketsBitacorasVFixture
 */
class TicketsBitacorasVFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'tickets_bitacoras_v';
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
                'bitacoraID' => 1,
                'userID' => 1,
                'report' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'date' => '2024-09-03 12:26:14',
            ],
        ];
        parent::init();
    }
}

