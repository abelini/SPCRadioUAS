<?php
declare(strict_types=1);

namespace SPC\Test\TestCase\Controller\Admin;

use SPC\Controller\Admin\ReportesCabinasController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Admin\ReportesCabinasController Test Case
 *
 * @uses \SPC\Controller\Admin\ReportesCabinasController
 */
class ReportesCabinasControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected array $fixtures = [
        'app.ReportesCabinas',
        'app.ReportesProgramas',
    ];

    /**
     * Test index method
     *
     * @return void
     * @uses \SPC\Controller\Admin\ReportesCabinasController::index()
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \SPC\Controller\Admin\ReportesCabinasController::view()
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \SPC\Controller\Admin\ReportesCabinasController::add()
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \SPC\Controller\Admin\ReportesCabinasController::edit()
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \SPC\Controller\Admin\ReportesCabinasController::delete()
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

