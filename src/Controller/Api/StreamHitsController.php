<?php
declare(strict_types=1);

namespace SPC\Controller\Api;

use SPC\Controller\ApiController;

/**
 * StreamHits Controller
 *
 * @property \SPC\Model\Table\StreamHitsTable $StreamHits
 */
class StreamHitsController extends ApiController
{
    public function add()
    {
        $this->autoRender = false;
        $this->request->allowMethod(['post']);

        $data = $this->request->getParsedBody();

        $defaults = [
            'format' => 'hls',
            'referer' => 'localhost',
            'refererType' => 'app',
            'ip' => '127.0.0.1',
            'userAgent' => 'Unknown',
            'country' => 'Mexico',
            'countryCode' => 'MX',
            'city' => 'Culiacan',
            'zip' => '80000',
            'lat' => null,
            'lon' => null,
        ];

        $filteredData = array_filter($data ?? [], fn($v) => $v !== '' && $v !== null);
        $mappedData = array_merge($defaults, $filteredData);

        $streamHit = $this->StreamHits->newEntity($mappedData);

        if ($this->StreamHits->save($streamHit)) {
            return $this->response->withStatus(201)->withStringBody('');
        }

        $errors = $streamHit->getErrors();
        $this->log('StreamHits save error: ' . json_encode($errors), 'error');
        return $this->response->withStatus(400)->withStringBody(json_encode($errors));
    }
}