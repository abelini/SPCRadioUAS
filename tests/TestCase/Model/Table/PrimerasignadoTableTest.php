<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PrimerasignadoTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PrimerasignadoTable Test Case
 */
class PrimerasignadoTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PrimerasignadoTable
     */
    protected $Primerasignado;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Primerasignado',
        'app.Mensajes',
        'app.Tweets',
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
        $config = $this->getTableLocator()->exists('Primerasignado') ? [] : ['className' => PrimerasignadoTable::class];
        $this->Primerasignado = $this->getTableLocator()->get('Primerasignado', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Primerasignado);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\PrimerasignadoTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\PrimerasignadoTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
