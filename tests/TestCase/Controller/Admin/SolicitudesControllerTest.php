<?php
declare(strict_types=1);

namespace SPC\Test\TestCase\Controller\Admin;

use SPC\Controller\Admin\SolicitudesController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Admin\SolicitudesController Test Case
 *
 * @uses \SPC\Controller\Admin\SolicitudesController
 */
class SolicitudesControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.Solicitudes',
        'app.PrimerAsignado',
        'app.SegundoAsignado',
        'app.Autorizante',
        'app.ProductorTecnico',
    ];

    /**
     * Test index method
     *
     * @return void
     * @uses \SPC\Controller\Admin\SolicitudesController::index()
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \SPC\Controller\Admin\SolicitudesController::view()
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \SPC\Controller\Admin\SolicitudesController::add()
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \SPC\Controller\Admin\SolicitudesController::edit()
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \SPC\Controller\Admin\SolicitudesController::delete()
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

