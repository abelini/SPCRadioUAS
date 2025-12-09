<?php
declare(strict_types=1);

namespace SPC\Test\TestCase\Controller;

use SPC\Controller\ReportesCabinasController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\ReportesCabinasController Test Case
 *
 * @uses \SPC\Controller\ReportesCabinasController
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
     * @uses \SPC\Controller\ReportesCabinasController::index()
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \SPC\Controller\ReportesCabinasController::view()
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \SPC\Controller\ReportesCabinasController::add()
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \SPC\Controller\ReportesCabinasController::edit()
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \SPC\Controller\ReportesCabinasController::delete()
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

