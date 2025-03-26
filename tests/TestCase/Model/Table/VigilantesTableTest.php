<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\VigilantesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\VigilantesTable Test Case
 */
class VigilantesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\VigilantesTable
     */
    protected $Vigilantes;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Vigilantes',
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
        $config = $this->getTableLocator()->exists('Vigilantes') ? [] : ['className' => VigilantesTable::class];
        $this->Vigilantes = $this->getTableLocator()->get('Vigilantes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Vigilantes);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\VigilantesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\VigilantesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
