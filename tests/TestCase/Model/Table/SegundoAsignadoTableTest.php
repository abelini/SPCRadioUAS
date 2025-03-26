<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SegundoAsignadoTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SegundoAsignadoTable Test Case
 */
class SegundoAsignadoTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SegundoAsignadoTable
     */
    protected $SegundoAsignado;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.SegundoAsignado',
        'app.Mensajes',
        'app.ReportesCabinas',
        'app.Solicitudes',
        'app.Tweets',
        'app.Permisos',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('SegundoAsignado') ? [] : ['className' => SegundoAsignadoTable::class];
        $this->SegundoAsignado = $this->getTableLocator()->get('SegundoAsignado', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->SegundoAsignado);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\SegundoAsignadoTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\SegundoAsignadoTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
