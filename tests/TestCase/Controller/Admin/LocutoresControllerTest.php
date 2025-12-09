<?php
declare(strict_types=1);

namespace SPC\Test\TestCase\Controller\Admin;

use SPC\Controller\Admin\LocutoresController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Admin\LocutoresController Test Case
 *
 * @uses \SPC\Controller\Admin\LocutoresController
 */
class LocutoresControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Locutores',
        'app.Asignaciones',
        'app.Permisos',
        'app.PermisosUsuarios',
    ];

    /**
     * Test index method
     *
     * @return void
     * @uses \SPC\Controller\Admin\LocutoresController::index()
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \SPC\Controller\Admin\LocutoresController::view()
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \SPC\Controller\Admin\LocutoresController::add()
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \SPC\Controller\Admin\LocutoresController::edit()
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \SPC\Controller\Admin\LocutoresController::delete()
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

