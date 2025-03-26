<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AsignadosTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AsignadosTable Test Case
 */
class AsignadosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AsignadosTable
     */
    protected $Asignados;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Asignados',
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
        $config = $this->getTableLocator()->exists('Asignados') ? [] : ['className' => AsignadosTable::class];
        $this->Asignados = $this->getTableLocator()->get('Asignados', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Asignados);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\AsignadosTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\AsignadosTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
