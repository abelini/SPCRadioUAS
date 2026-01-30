<?php
declare(strict_types=1);

namespace SPC\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use SPC\Model\Table\CategoriasProgramasTable;

/**
 * SPC\Model\Table\CategoriasProgramasTable Test Case
 */
class CategoriasProgramasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \SPC\Model\Table\CategoriasProgramasTable
     */
    protected $CategoriasProgramas;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.CategoriasProgramas',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('CategoriasProgramas') ? [] : ['className' => CategoriasProgramasTable::class];
        $this->CategoriasProgramas = $this->getTableLocator()->get('CategoriasProgramas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->CategoriasProgramas);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \SPC\Model\Table\CategoriasProgramasTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
