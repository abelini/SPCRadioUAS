<?php
declare(strict_types=1);

namespace SPC\Test\TestCase\Controller\Api;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * Caso de prueba para LocutoresController de la API.
 *
 * @uses \SPC\Controller\Api\LocutoresController
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
        'app.Roles',
        'app.Asignaciones',
        'app.Horarios',
        'app.Locutores',
    ];

    /**
     * Prueba el endpoint /api/locutores?ahora
     *
     * @return void
     */
    public function testLocutoresAhora(): void
    {
        $this->get('/api/locutores?ahora');

        $this->assertResponseOk();
        $this->assertHeader('Content-Type', 'application/json');

        $response = json_decode((string)$this->_response->getBody(), true);
        $this->assertArrayHasKey('name', $response);
        $this->assertArrayHasKey('starts', $response);
        $this->assertArrayHasKey('ends', $response);
    }

    /**
     * Prueba el endpoint /api/locutores/index
     *
     * @return void
     */
    public function testLocutoresIndex(): void
    {
        $this->get('/api/locutores/index');

        $this->assertResponseOk();
        $this->assertHeader('Content-Type', 'application/json');

        $response = json_decode((string)$this->_response->getBody(), true);
        $this->assertArrayHasKey('name', $response);
    }
}
