<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\HorariosTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\HorariosTable Test Case
 */
class HorariosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\HorariosTable
     */
    protected $Horarios;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Horarios',
        'app.Turnos',
        'app.Asignaciones',
        'app.Dias',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Horarios') ? [] : ['className' => HorariosTable::class];
        $this->Horarios = $this->getTableLocator()->get('Horarios', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Horarios);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\HorariosTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\HorariosTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
