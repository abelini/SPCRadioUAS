<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ReportesProgramasTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ReportesProgramasTable Test Case
 */
class ReportesProgramasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ReportesProgramasTable
     */
    protected $ReportesProgramas;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.ReportesProgramas',
        'app.ReportesCabinas',
        'app.Programas',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ReportesProgramas') ? [] : ['className' => ReportesProgramasTable::class];
        $this->ReportesProgramas = $this->getTableLocator()->get('ReportesProgramas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->ReportesProgramas);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ReportesProgramasTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\ReportesProgramasTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
