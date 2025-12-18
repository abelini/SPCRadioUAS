<?php
declare(strict_types=1);

namespace SPC\Test\TestCase\Controller;

use SPC\Controller\BitacoraVigilanciaController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\BitacoraVigilanciaController Test Case
 *
 * @uses \SPC\Controller\BitacoraVigilanciaController
 */
class BitacoraVigilanciaControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.BitacoraVigilancia',
        'app.Vigilantes',
        'app.TipoBitacora',
        'app.ReportesVigilancia',
    ];

    /**
     * Test index method
     *
     * @return void
     * @uses \SPC\Controller\BitacoraVigilanciaController::index()
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \SPC\Controller\BitacoraVigilanciaController::view()
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \SPC\Controller\BitacoraVigilanciaController::add()
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \SPC\Controller\BitacoraVigilanciaController::edit()
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \SPC\Controller\BitacoraVigilanciaController::delete()
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

