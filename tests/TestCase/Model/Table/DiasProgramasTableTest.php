<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DiasProgramasTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DiasProgramasTable Test Case
 */
class DiasProgramasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DiasProgramasTable
     */
    protected $DiasProgramas;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.DiasProgramas',
        'app.Dias',
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
        $config = $this->getTableLocator()->exists('DiasProgramas') ? [] : ['className' => DiasProgramasTable::class];
        $this->DiasProgramas = $this->getTableLocator()->get('DiasProgramas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->DiasProgramas);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\DiasProgramasTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\DiasProgramasTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
