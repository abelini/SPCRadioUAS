<?php
declare(strict_types=1);

namespace SPC\Test\TestCase\Model\Table;

use SPC\Model\Table\ReportesCabinasTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ReportesCabinasTable Test Case
 */
class ReportesCabinasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \SPC\Model\Table\ReportesCabinasTable
     */
    protected $ReportesCabinas;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.ReportesCabinas',
        'app.ReportesProgramas',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ReportesCabinas') ? [] : ['className' => ReportesCabinasTable::class];
        $this->ReportesCabinas = $this->getTableLocator()->get('ReportesCabinas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->ReportesCabinas);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \SPC\Model\Table\ReportesCabinasTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

