<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DiasHorariosTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DiasHorariosTable Test Case
 */
class DiasHorariosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DiasHorariosTable
     */
    protected $DiasHorarios;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.DiasHorarios',
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
        $config = $this->getTableLocator()->exists('DiasHorarios') ? [] : ['className' => DiasHorariosTable::class];
        $this->DiasHorarios = $this->getTableLocator()->get('DiasHorarios', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->DiasHorarios);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\DiasHorariosTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\DiasHorariosTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
