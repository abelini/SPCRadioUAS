<?php

declare(strict_types=1);

namespace SPC\Service;

use Cake\Core\Configure;
use Cake\ORM\Locator\LocatorAwareTrait;
use SPC\Service\GeminiService;

class SocialContentService
{
    use LocatorAwareTrait;

    /**
     * Genera contenido social para un programa buscando por su nombre.
     *
     * @param string $nombrePrograma Nombre del programa
     * @return string Respuesta generada por Gemini
     */
    public function generateForProgramName(string $nombrePrograma): string
    {
        $programasTable = $this->getTableLocator()->get('Programas');
        $programa = $programasTable
            ->find()
            ->select(['ID', 'name', 'conduccion'])
            ->where(['name' => $nombrePrograma])
            ->contain('TemasProgramas', fn($query) => $query->select(['ID', 'ProgramaID', 'tema', 'invitados', 'tags']))
            ->first();

        $nombre = $programa ? (string)$programa->get('name') : $nombrePrograma;
        $conduccion = $programa ? (string)$programa->get('conduccion') : '';
        $temaEntity = $programa ? $programa->get('tema') : null;
        $tema = $temaEntity ? (string)$temaEntity->get('tema') : '';
        $invitados = $temaEntity ? (string)$temaEntity->get('invitados') : '';
        $tags = $temaEntity ? (string)$temaEntity->get('tags') : '';

        return $this->buildAndGenerate('live_show', [
            '%programa%' => 'Programa: ' . $nombre,
            '%conduccion%' => 'Conductor/a: ' . $conduccion,
            '%invitados%' => $invitados !== '' ? 'Invitado(s): ' . $invitados : '',
            '%tema%' => $tema !== '' ? 'Tema del día: ' . $tema : '',
            '%keywords%' => $tags !== '' ? 'Palabras clave/Estilo: ' . $tags : '',
        ]);
    }

    /**
     * Genera contenido social buscando por ID de programa.
     *
     * @param int $programaID ID del programa
     * @return string Respuesta generada por Gemini
     */
    public function generateForProgramaID(int $programaID): string
    {
        $programasTable = $this->getTableLocator()->get('Programas');
        $programa = $programasTable
            ->find()
            ->select(['ID', 'name', 'conduccion'])
            ->where(['Programas.ID' => $programaID])
            ->contain('TemasProgramas', fn($query) => $query->select(['ID', 'ProgramaID', 'tema', 'invitados', 'tags']))
            ->first();

        $nombre = $programa ? (string)$programa->get('name') : '';
        $conduccion = $programa ? (string)$programa->get('conduccion') : '';
        $temaEntity = $programa ? $programa->get('tema') : null;
        $tema = $temaEntity ? (string)$temaEntity->get('tema') : '';
        $invitados = $temaEntity ? (string)$temaEntity->get('invitados') : '';
        $tags = $temaEntity ? (string)$temaEntity->get('tags') : '';

        return $this->buildAndGenerate('live_show', [
            '%programa%' => 'Programa: ' . $nombre,
            '%conduccion%' => 'Conductor/a: ' . $conduccion,
            '%invitados%' => $invitados !== '' ? 'Invitado(s): ' . $invitados : '',
            '%tema%' => $tema !== '' ? 'Tema del día: ' . $tema : '',
            '%keywords%' => $tags !== '' ? 'Palabras clave/Estilo: ' . $tags : '',
        ]);
    }

    /**
     * Genera contenido social buscando por ID de TemasProgramas.
     *
     * @param int $temasProgramaID ID del registro en temas_programas
     * @return string Respuesta generada por Gemini
     */
    public function generateForTemasProgramaID(int $temasProgramaID): string
    {
        $temasTable = $this->getTableLocator()->get('TemasProgramas');
        $temaRow = $temasTable
            ->find()
            ->contain(['Programas' => fn($q) => $q->select(['ID', 'name', 'conduccion'])])
            ->where(['TemasProgramas.ID' => $temasProgramaID])
            ->first();

        $programa = $temaRow ? $temaRow->get('programa') : null;
        $nombre = $programa ? (string)$programa->get('name') : '';
        $conduccion = $programa ? (string)$programa->get('conduccion') : '';
        $tema = $temaRow ? (string)$temaRow->get('tema') : '';
        $invitados = $temaRow ? (string)$temaRow->get('invitados') : '';
        $tags = $temaRow ? (string)$temaRow->get('tags') : '';

        return $this->buildAndGenerate('live_show', [
            '%programa%' => 'Programa: ' . $nombre,
            '%conduccion%' => 'Conductor/a: ' . $conduccion,
            '%invitados%' => $invitados !== '' ? 'Invitado(s): ' . $invitados : '',
            '%tema%' => $tema !== '' ? 'Tema del día: ' . $tema : '',
            '%keywords%' => $tags !== '' ? 'Palabras clave/Estilo: ' . $tags : '',
        ]);
    }

    /**
     * Construye el prompt y ejecuta GeminiService.
     *
     * @param string $type Tipo de prompt configurado en app_local.php
     * @param array<string, string> $replacements Mapa de reemplazos
     * @return string Respuesta generada
     */
    protected function buildAndGenerate(string $type, array $replacements): string
    {
        $prompt = Configure::read('Prompts.' . $type);

        $search = array_keys($replacements);
        $replace = array_values($replacements);

        $finalPrompt = str_replace($search, $replace, $prompt);

        $gemini = new GeminiService();

        return $gemini->generateText($finalPrompt);
    }
}
