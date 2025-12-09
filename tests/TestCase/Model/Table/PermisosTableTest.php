<?php
declare(strict_types=1);

namespace SPC\Test\TestCase\Model\Table;

use SPC\Model\Table\PermisosTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PermisosTable Test Case
 */
class PermisosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \SPC\Model\Table\PermisosTable
     */
    protected $Permisos;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Permisos',
        'app.Usuarios',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Permisos') ? [] : ['className' => PermisosTable::class];
        $this->Permisos = $this->getTableLocator()->get('Permisos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Permisos);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\PermisosTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

