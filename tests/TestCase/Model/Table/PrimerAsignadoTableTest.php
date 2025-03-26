<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PrimerAsignadoTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PrimerAsignadoTable Test Case
 */
class PrimerAsignadoTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PrimerAsignadoTable
     */
    protected $PrimerAsignado;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.PrimerAsignado',
        'app.Solicitudes',
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
        $config = $this->getTableLocator()->exists('PrimerAsignado') ? [] : ['className' => PrimerAsignadoTable::class];
        $this->PrimerAsignado = $this->getTableLocator()->get('PrimerAsignado', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->PrimerAsignado);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\PrimerAsignadoTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\PrimerAsignadoTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
