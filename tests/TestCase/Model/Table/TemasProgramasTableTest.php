<?php
declare(strict_types=1);

namespace SPC\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use SPC\Model\Table\TemasProgramasTable;

/**
 * SPC\Model\Table\TemasProgramasTable Test Case
 */
class TemasProgramasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \SPC\Model\Table\TemasProgramasTable
     */
    protected $TemasProgramas;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.TemasProgramas',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('TemasProgramas') ? [] : ['className' => TemasProgramasTable::class];
        $this->TemasProgramas = $this->getTableLocator()->get('TemasProgramas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->TemasProgramas);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \SPC\Model\Table\TemasProgramasTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
