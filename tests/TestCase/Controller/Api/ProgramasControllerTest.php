<?php
declare(strict_types=1);

namespace SPC\Test\TestCase\Controller\Api;

use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * Caso de prueba para ProgramasController de la API.
 *
 * @uses \SPC\Controller\Api\ProgramasController
 */
class ProgramasControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Accesorios (Fixtures) requeridos para las pruebas.
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Programas',
        'app.CategoriasProgramas',
        'app.Dias',
        'app.DiasProgramas',
    ];

    /**
     * Prueba el caso de error cuando no se pasa el argumento "name".
     *
     * @return void
     */
    public function testGetWithoutName(): void
    {
        $this->get('/api/programas/get');

        $this->assertResponseCode(400);
        $this->assertHeader('Content-Type', 'application/json');

        $response = json_decode((string)$this->_response->getBody(), true);
        $this->assertArrayHasKey('error', $response);
        $this->assertEquals('El argumento "name" es obligatorio y debe ser un texto.', $response['error']);
    }

    /**
     * Prueba el caso cuando el programa no es encontrado (HTTP 404).
     *
     * @return void
     */
    public function testGetNotFound(): void
    {
        $this->get('/api/programas/get?name=99');

        $this->assertResponseCode(404);
        $this->assertHeader('Content-Type', 'application/json');

        $response = json_decode((string)$this->_response->getBody(), true);
        $this->assertArrayHasKey('error', $response);
        $this->assertEquals('show_not_found', $response['error']);
        $this->assertArrayHasKey('message', $response);
        $this->assertEquals('No se encontró el programa 99 en SPC', $response['message']);
    }

    /**
     * Prueba el endpoint /api/programas/list — respuesta JSON con estructura correcta.
     *
     * @return void
     */
    public function testListReturnsJson(): void
    {
        $this->get('/api/programas/list');

        $this->assertResponseOk();
        $this->assertHeader('Content-Type', 'application/json');

        $response = json_decode((string)$this->_response->getBody(), true);
        $this->assertIsArray($response);
    }

    /**
     * Prueba que cada programa tenga la estructura esperada.
     *
     * @return void
     */
    public function testListEntryStructure(): void
    {
        $this->get('/api/programas/list');

        $response = json_decode((string)$this->_response->getBody(), true);
        if (!empty($response)) {
            $entry = $response[0];
            $this->assertArrayHasKey('program', $entry);
            $this->assertArrayHasKey('produccion', $entry);
            $this->assertArrayHasKey('conduccion', $entry);
            $this->assertArrayHasKey('musical', $entry);
            $this->assertArrayHasKey('schedule', $entry);
            $this->assertIsArray($entry['schedule']);
        }
    }
}
