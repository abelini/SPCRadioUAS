<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ReportesVigilanciaTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ReportesVigilanciaTable Test Case
 */
class ReportesVigilanciaTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ReportesVigilanciaTable
     */
    protected $ReportesVigilancia;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.ReportesVigilancia',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ReportesVigilancia') ? [] : ['className' => ReportesVigilanciaTable::class];
        $this->ReportesVigilancia = $this->getTableLocator()->get('ReportesVigilancia', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->ReportesVigilancia);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ReportesVigilanciaTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
