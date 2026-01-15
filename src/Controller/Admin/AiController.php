<?php
declare(strict_types=1);

namespace SPC\Controller\Admin;

use SPC\Controller\AppController;
use SPC\Service\GeminiService;


class AiController extends AppController
{

    public function index()
    {
        $respuesta = '';

        if ($this->request->is('post')) {
            $prompt = $this->request->getData('prompt') ?? 'Dime una adivinanza';

            if (!empty($prompt)) {
                $gemini = new GeminiService();
                $respuesta = $gemini->generateText($prompt, 'gemini-2.5-flash');
            }
        }

        $this->set(compact('respuesta'));
    }


}
