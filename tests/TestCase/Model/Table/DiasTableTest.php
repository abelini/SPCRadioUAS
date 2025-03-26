<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DiasTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DiasTable Test Case
 */
class DiasTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DiasTable
     */
    protected $Dias;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Dias',
        'app.Asignaciones',
        'app.Horarios',
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
        $config = $this->getTableLocator()->exists('Dias') ? [] : ['className' => DiasTable::class];
        $this->Dias = $this->getTableLocator()->get('Dias', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Dias);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\DiasTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
