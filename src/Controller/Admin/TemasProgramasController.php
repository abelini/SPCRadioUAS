<?php
declare(strict_types=1);

namespace SPC\Controller\Admin;

use SPC\Controller\AppController;
use Cake\Core\Configure;
use SPC\Service\GeminiService;
use Cake\Http\Response;

class TemasProgramasController extends AppController
{

    public function index()
    {
        $query = $this->TemasProgramas->find()
            ->contain(['Programas'])
            ->orderByAsc('Programas.name');
        $temasProgramas = $this->paginate($query);

        $this->set(compact('temasProgramas'));
    }


    public function executePrompt($id = null): Response
    {
        $this->request->allowMethod(['post', 'ajax']);

        $prompt = Configure::read('Prompts.liveShow');

        $tema = $this->getTableLocator()->get('TemasProgramas')
            ->find()
            ->where(['TemasProgramas.ID' => $id])
            ->contain('Programas')
            ->first();

        $programa = 'Programa: ' . $tema->programa->name;
        $conduccion = 'Conductor/a: ' . $tema->programa->conduccion;
        $invitados = $tema->invitados ? 'Invitado(s): ' . $tema->invitados : '';
        $keywords = $tema->tags ? 'Palabras clave/Estilo: ' . $tema->tags : '';
        $tema = $tema->tema ? 'Tema del día: ' . $tema->tema : '';

        $prompt = str_replace(
            ['%programa%', '%conduccion%', '%invitados%', '%tema%', '%keywords%'],
            [$programa, $conduccion, $invitados, $tema, $keywords],
            $prompt
        );

        $gemini = new GeminiService();
        $respuesta = $gemini->generateText($prompt);

        return $this->response->withStringBody($respuesta);
    }

    public function generateSocialContent($id = null): Response
    {
        $prompt = Configure::read('Prompts.liveShow');

        $tema = $this->TemasProgramas->find()
            ->where(['TemasProgramas.programaID' => $id])
            ->contain('Programas')
            ->first();

        $programa = $tema->programa->name;
        $conduccion = $tema->programa->conduccion;
        $invitados = $tema->invitados ? 'Invitado(s): ' . $tema->invitados : '';
        $keywords = $tema->tags ? 'Palabras clave/Estilo: ' . $tema->tags : '';
        $tema = $tema->tema ? 'Tema del día: ' . $tema->tema : '';

        $prompt = str_replace(
            ['%programa%', '%conduccion%', '%invitados%', '%tema%', '%keywords%'],
            [$programa, $conduccion, $invitados, $tema, $keywords],
            $prompt
        );

        $gemini = new GeminiService();
        $respuesta = $gemini->generateText($prompt);
        $this->set('prompt', $respuesta);

        return $this->render();
    }

    public function view($id = null)
    {
        $temasPrograma = $this->TemasProgramas->get($id, contain: ['Programas']);
        $this->set(compact('temasPrograma'));
    }

    public function add()
    {
        $temasPrograma = $this->TemasProgramas->newEmptyEntity();
        if ($this->request->is('post')) {
            $temasPrograma = $this->TemasProgramas->patchEntity($temasPrograma, $this->request->getData());
            if ($this->TemasProgramas->save($temasPrograma)) {
                $this->Flash->success(__('The temas programa has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The temas programa could not be saved. Please, try again.'));
        }
        $programas = $this->TemasProgramas->Programas->find('list')->all();
        $this->set(compact('temasPrograma', 'programas'));
    }

    public function edit($id = null)
    {
        $temasPrograma = $this->TemasProgramas->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $temasPrograma = $this->TemasProgramas->patchEntity($temasPrograma, $this->request->getData());
            if ($this->TemasProgramas->save($temasPrograma)) {
                $this->Flash->success(__('The temas programa has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The temas programa could not be saved. Please, try again.'));
        }
        $programas = $this->TemasProgramas->Programas->find('list', limit: 200)->all();
        $this->set(compact('temasPrograma', 'programas'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $temasPrograma = $this->TemasProgramas->get($id);
        if ($this->TemasProgramas->delete($temasPrograma)) {
            $this->Flash->success(__('The temas programa has been deleted.'));
        } else {
            $this->Flash->error(__('The temas programa could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
