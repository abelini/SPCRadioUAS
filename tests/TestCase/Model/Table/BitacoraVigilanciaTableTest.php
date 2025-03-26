<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BitacoraVigilanciaTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BitacoraVigilanciaTable Test Case
 */
class BitacoraVigilanciaTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\BitacoraVigilanciaTable
     */
    protected $BitacoraVigilancia;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.BitacoraVigilancia',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('BitacoraVigilancia') ? [] : ['className' => BitacoraVigilanciaTable::class];
        $this->BitacoraVigilancia = $this->getTableLocator()->get('BitacoraVigilancia', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->BitacoraVigilancia);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\BitacoraVigilanciaTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
