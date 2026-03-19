<?php
declare(strict_types=1);

namespace SPC\Controller\Api;

use SPC\Controller\ApiController;
use SPC\Service\ShoutcastService;
use Cake\Core\Configure;
use Cake\Http\Exception\BadRequestException;
use Cake\Http\Exception\ForbiddenException;
use RuntimeException;

class MetadataController extends ApiController
{
    private const MIN_TEXT_LENGTH = 1;

    private ShoutcastService $shoutcastService;

    /**
     * Inicializa el controlador con sus dependencias
     */
    public function initialize(): void
    {
        parent::initialize();
        $this->shoutcastService = new ShoutcastService();
    }

    /**
     * Endpoint para actualizar los metadatos del stream
     * 
     * POST /api/metadata/update
     * Headers: Authorization: Bearer {token}
     * Body: { "text": "Artist - Song Title" }
     */
    public function update()
    {
        $this->request->allowMethod(['post']);

        $this->validateAuthorization();
        $text = $this->extractAndValidateText();

        try {
            $this->shoutcastService->updateMetadata($text);
            return $this->buildSuccessResponse();
        } catch (RuntimeException $e) {
            return $this->buildErrorResponse($e->getMessage());
        }
    }

    /**
     * Valida el token de autorización en el header
     */
    private function validateAuthorization(): void
    {
        $authHeader = $this->request->getHeaderLine('Authorization');

        if (!$this->isValidToken($authHeader)) {
            throw new ForbiddenException('Invalid or missing authorization token');
        }
    }

    /**
     * Verifica si el token de autorización es válido
     */
    private function isValidToken(string $header): bool
    {
        if (!str_starts_with($header, 'Bearer ')) {
            return false;
        }

        $token = substr($header, 7);
        $expectedToken = Configure::read('SensitiveData.Shoutcast.token');

        if (!is_string($expectedToken) || $expectedToken === '') {
            return false;
        }

        return hash_equals($expectedToken, $token);
    }

    /**
     * Extrae y valida el texto desde el cuerpo de la petición
     */
    private function extractAndValidateText(): string
    {
        $text = $this->request->getData('text');

        if (!is_string($text)) {
            throw new BadRequestException('Text field must be a string');
        }

        if (strlen(trim($text)) < self::MIN_TEXT_LENGTH) {
            throw new BadRequestException('Text field is required and cannot be empty');
        }

        return $text;
    }

    /**
     * Construye la respuesta JSON de éxito
     */
    private function buildSuccessResponse()
    {
        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode([
                'status' => 'success',
                'message' => 'Metadata updated successfully'
            ]));
    }

    /**
     * Construye la respuesta JSON de error
     */
    private function buildErrorResponse(string $message)
    {
        return $this->response
            ->withStatus(500)
            ->withType('application/json')
            ->withStringBody(json_encode([
                'status' => 'error',
                'message' => $message
            ]));
    }
}