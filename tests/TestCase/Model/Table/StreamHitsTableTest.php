<?php
declare(strict_types=1);

namespace SPC\Test\TestCase\Model\Table;

use Cake\TestSuite\TestCase;
use SPC\Model\Table\StreamHitsTable;

/**
 * SPC\Model\Table\StreamHitsTable Test Case
 */
class StreamHitsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \SPC\Model\Table\StreamHitsTable
     */
    protected $StreamHits;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.StreamHits',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('StreamHits') ? [] : ['className' => StreamHitsTable::class];
        $this->StreamHits = $this->getTableLocator()->get('StreamHits', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->StreamHits);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \SPC\Model\Table\StreamHitsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
