<?php
declare(strict_types=1);

namespace SPC\Test\TestCase\Model\Table;

use SPC\Model\Table\TicketsBitacorasVTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TicketsBitacorasVTable Test Case
 */
class TicketsBitacorasVTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \SPC\Model\Table\TicketsBitacorasVTable
     */
    protected $TicketsBitacorasV;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.TicketsBitacorasV',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('TicketsBitacorasV') ? [] : ['className' => TicketsBitacorasVTable::class];
        $this->TicketsBitacorasV = $this->getTableLocator()->get('TicketsBitacorasV', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->TicketsBitacorasV);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \SPC\Model\Table\TicketsBitacorasVTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

