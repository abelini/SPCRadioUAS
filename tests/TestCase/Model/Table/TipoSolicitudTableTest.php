<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TipoSolicitudTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TipoSolicitudTable Test Case
 */
class TipoSolicitudTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TipoSolicitudTable
     */
    protected $TipoSolicitud;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.TipoSolicitud',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('TipoSolicitud') ? [] : ['className' => TipoSolicitudTable::class];
        $this->TipoSolicitud = $this->getTableLocator()->get('TipoSolicitud', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->TipoSolicitud);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\TipoSolicitudTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
