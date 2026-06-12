<?php
declare(strict_types=1);

namespace SPC\Controller\Api;

use SPC\Controller\ApiController;
use Cake\Cache\Cache;
use Cake\Http\Response;

/**
 * Controlador de Programas para la API pública.
 * Proporciona endpoints para consultar información de programas y su programación semanal.
 */
class ProgramasController extends ApiController
{
    /**
     * Lista todos los programas agrupados por nombre con horario semanal.
     *
     * GET /api/programas/list
     *
     * Los programas con horarios distintos (mismo nombre) aparecen agrupados,
     * incluyendo todos sus días y horas de transmisión.
     *
     * @return \Cake\Http\Response
     */
    public function list(): Response
    {
        $this->autoRender = false;

        $programas = $this->getTableLocator()->get('Programas')
            ->find()
            ->where(['Programas.musical' => false])
            ->contain(['CategoriasProgramas', 'Dias'])
            ->orderBy('Programas.name')
            ->all();

        $grouped = [];
        foreach ($programas as $p) {
            $name = $p->name;
            if (!isset($grouped[$name])) {
                $grouped[$name] = [
                    'program' => $name,
                    'produccion' => $p->produccion,
                    'conduccion' => $p->conduccion,
                    //                    'musical' => (bool)$p->musical,
                    'image_url' => $p->image_url,
                    'category' => $p->categoria ? [
                        'name' => $p->categoria->name,
                        'slug' => $p->categoria->slug,
                        //'icon' => $p->categoria->icon,
                    ] : null,
                    'schedule' => [],
                ];
            }

            $startTime = $p->horaInicio ? $p->horaInicio->format('H:i') : '00:00';
            $endTime = $p->horaFin ? $p->horaFin->format('H:i') : '00:00';

            if ($p->dias) {
                foreach ($p->dias as $dia) {
                    $grouped[$name]['schedule'][] = [
                        'day' => $dia->name,
                        'start' => $startTime,
                        'end' => $endTime,
                        '_day_id' => $dia->ID,
                        '_start_time' => $p->horaInicio ? $p->horaInicio->format('H:i:s') : '00:00:00',
                    ];
                }
            }
        }

        foreach ($grouped as &$program) {
            usort($program['schedule'], function (array $a, array $b): int {
                if ($a['_day_id'] === $b['_day_id']) {
                    return strcmp($a['_start_time'], $b['_start_time']);
                }
                return $a['_day_id'] <=> $b['_day_id'];
            });

            $program['schedule'] = array_map(fn(array $item): array => [
                'day' => $item['day'],
                'start' => $item['start'],
                'end' => $item['end'],
            ], $program['schedule']);
        }
        unset($program);

        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode(array_values($grouped), JSON_UNESCAPED_UNICODE));
    }

    /**
     * Obtiene los detalles y horarios de un programa por su nombre.
     *
     * GET /api/programas/get?name={Nombre}
     *
     * @return \Cake\Http\Response
     */
    public function get(): Response
    {
        $this->autoRender = false;
        $name = $this->request->getQuery('name');

        if (empty($name) || !is_string($name)) {
            return $this->response
                ->withType('application/json')
                ->withStatus(400)
                ->withStringBody(json_encode([
                    'error' => 'El argumento "name" es obligatorio y debe ser un texto.',
                ]));
        }

        $cacheKey = 'programa_info_' . md5(strtolower(trim($name)));
        $response = Cache::read($cacheKey, 'programas_api');

        if ($response === null) {
            $programas = $this->getTableLocator()->get('Programas')
                ->find()
                ->where(['Programas.name' => $name])
                ->contain(['CategoriasProgramas', 'Dias'])
                ->all();

            if ($programas->isEmpty()) {
                return $this->response
                    ->withType('application/json')
                    ->withStatus(404)
                    ->withStringBody(json_encode([
                        'error' => 'show_not_found',
                        'message' => sprintf('No se encontró el programa %s en SPC', $name),
                    ]));
            }

            // Usar los metadatos del primer programa coincidente
            $firstProgram = $programas->first();
            $categoryData = null;

            if ($firstProgram !== null && $firstProgram->categoria !== null) {
                $categoryData = [
                    'name' => $firstProgram->categoria->name,
                    'icon' => $firstProgram->categoria->icon,
                ];
            }

            $scheduleList = [];

            foreach ($programas as $programa) {
                $startTime = $programa->horaInicio ? $programa->horaInicio->format('H:i') : '00:00';
                $endTime = $programa->horaFin ? $programa->horaFin->format('H:i') : '00:00';

                if ($programa->dias) {
                    foreach ($programa->dias as $dia) {
                        $scheduleList[] = [
                            'day' => $dia->name,
                            'start' => $startTime,
                            'end' => $endTime,
                            '_day_id' => $dia->ID,
                            '_start_time' => $programa->horaInicio ? $programa->horaInicio->format('H:i:s') : '00:00:00',
                        ];
                    }
                }
            }

            // Ordenar por el orden de los días de la semana y luego por hora de inicio si hay elementos
            if (!empty($scheduleList)) {
                usort($scheduleList, function (array $a, array $b): int {
                    if ($a['_day_id'] === $b['_day_id']) {
                        return strcmp($a['_start_time'], $b['_start_time']);
                    }

                    return $a['_day_id'] <=> $b['_day_id'];
                });

                // Limpiar las llaves temporales de ordenamiento
                $finalSchedule = array_map(function (array $item): array {
                    return [
                        'day' => $item['day'],
                        'start' => $item['start'],
                        'end' => $item['end'],
                    ];
                }, $scheduleList);
            } else {
                $finalSchedule = [];
            }

            $response = [
                'program' => $firstProgram->name,
                'produccion' => $firstProgram->produccion,
                'conduccion' => $firstProgram->conduccion,
                'category' => $categoryData,
                'schedule' => $finalSchedule,
            ];

            Cache::write($cacheKey, $response, 'programas_api');
        }

        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode($response));
    }
}
