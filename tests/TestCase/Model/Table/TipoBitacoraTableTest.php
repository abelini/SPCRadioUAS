<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TipoBitacoraTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TipoBitacoraTable Test Case
 */
class TipoBitacoraTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TipoBitacoraTable
     */
    protected $TipoBitacora;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.TipoBitacora',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('TipoBitacora') ? [] : ['className' => TipoBitacoraTable::class];
        $this->TipoBitacora = $this->getTableLocator()->get('TipoBitacora', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->TipoBitacora);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\TipoBitacoraTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
