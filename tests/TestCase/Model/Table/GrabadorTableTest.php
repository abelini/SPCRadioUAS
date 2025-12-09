<?php
declare(strict_types=1);

namespace SPC\Test\TestCase\Model\Table;

use SPC\Model\Table\GrabadorTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\GrabadorTable Test Case
 */
class GrabadorTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \SPC\Model\Table\GrabadorTable
     */
    protected $Grabador;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Grabador',
        'app.Mensajes',
        'app.ReportesCabinas',
        'app.Solicitudes',
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
        $config = $this->getTableLocator()->exists('Grabador') ? [] : ['className' => GrabadorTable::class];
        $this->Grabador = $this->getTableLocator()->get('Grabador', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Grabador);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \SPC\Model\Table\GrabadorTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \SPC\Model\Table\GrabadorTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

