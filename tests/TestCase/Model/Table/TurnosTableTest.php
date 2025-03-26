<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TurnosTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TurnosTable Test Case
 */
class TurnosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TurnosTable
     */
    protected $Turnos;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Turnos',
        'app.Horarios',
        'app.Roles',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Turnos') ? [] : ['className' => TurnosTable::class];
        $this->Turnos = $this->getTableLocator()->get('Turnos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Turnos);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\TurnosTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
