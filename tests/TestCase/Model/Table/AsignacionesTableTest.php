<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AsignacionesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AsignacionesTable Test Case
 */
class AsignacionesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AsignacionesTable
     */
    protected $Asignaciones;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Asignaciones',
        'app.Usuarios',
        'app.Dias',
        'app.Horarios',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Asignaciones') ? [] : ['className' => AsignacionesTable::class];
        $this->Asignaciones = $this->getTableLocator()->get('Asignaciones', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Asignaciones);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\AsignacionesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\AsignacionesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
