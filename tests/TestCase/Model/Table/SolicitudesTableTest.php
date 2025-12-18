<?php
declare(strict_types=1);

namespace SPC\Test\TestCase\Model\Table;

use SPC\Model\Table\SolicitudesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SolicitudesTable Test Case
 */
class SolicitudesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \SPC\Model\Table\SolicitudesTable
     */
    protected $Solicitudes;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Solicitudes',
        'app.Usuarios',
        'app.PrimerAsignado',
        'app.SegundoAsignado',
        'app.Grabador',
        'app.Autorizantes',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Solicitudes') ? [] : ['className' => SolicitudesTable::class];
        $this->Solicitudes = $this->getTableLocator()->get('Solicitudes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Solicitudes);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \SPC\Model\Table\SolicitudesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \SPC\Model\Table\SolicitudesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

