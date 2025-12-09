<?php
declare(strict_types=1);

namespace SPC\Test\TestCase\Model\Table;

use SPC\Model\Table\PermisosUsuariosTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PermisosUsuariosTable Test Case
 */
class PermisosUsuariosTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \SPC\Model\Table\PermisosUsuariosTable
     */
    protected $PermisosUsuarios;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.PermisosUsuarios',
        'app.Usuarios',
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
        $config = $this->getTableLocator()->exists('PermisosUsuarios') ? [] : ['className' => PermisosUsuariosTable::class];
        $this->PermisosUsuarios = $this->getTableLocator()->get('PermisosUsuarios', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->PermisosUsuarios);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \SPC\Model\Table\PermisosUsuariosTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \SPC\Model\Table\PermisosUsuariosTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

