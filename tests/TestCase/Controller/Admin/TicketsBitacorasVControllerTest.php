<?php
declare(strict_types=1);

namespace SPC\Test\TestCase\Controller\Admin;

use SPC\Controller\Admin\TicketsBitacorasVController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Admin\TicketsBitacorasVController Test Case
 *
 * @uses \SPC\Controller\Admin\TicketsBitacorasVController
 */
class TicketsBitacorasVControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.TicketsBitacorasV',
        'app.BitacoraVigilancia',
    ];

    /**
     * Test index method
     *
     * @return void
     * @uses \SPC\Controller\Admin\TicketsBitacorasVController::index()
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \SPC\Controller\Admin\TicketsBitacorasVController::view()
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \SPC\Controller\Admin\TicketsBitacorasVController::add()
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \SPC\Controller\Admin\TicketsBitacorasVController::edit()
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \SPC\Controller\Admin\TicketsBitacorasVController::delete()
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}

