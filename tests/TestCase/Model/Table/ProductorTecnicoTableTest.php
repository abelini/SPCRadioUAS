<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProductorTecnicoTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProductorTecnicoTable Test Case
 */
class ProductorTecnicoTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ProductorTecnicoTable
     */
    protected $ProductorTecnico;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.ProductorTecnico',
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
        $config = $this->getTableLocator()->exists('ProductorTecnico') ? [] : ['className' => ProductorTecnicoTable::class];
        $this->ProductorTecnico = $this->getTableLocator()->get('ProductorTecnico', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->ProductorTecnico);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ProductorTecnicoTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\ProductorTecnicoTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
