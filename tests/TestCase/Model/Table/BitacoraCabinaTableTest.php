<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\BitacoraCabinaTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\BitacoraCabinaTable Test Case
 */
class BitacoraCabinaTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\BitacoraCabinaTable
     */
    protected $BitacoraCabina;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.BitacoraCabina',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('BitacoraCabina') ? [] : ['className' => BitacoraCabinaTable::class];
        $this->BitacoraCabina = $this->getTableLocator()->get('BitacoraCabina', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->BitacoraCabina);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\BitacoraCabinaTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
