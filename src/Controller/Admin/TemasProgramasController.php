<?php
declare(strict_types=1);

namespace SPC\Controller\Admin;

use SPC\Controller\AppController;
use Cake\Core\Configure;
use Cake\ORM\Query\SelectQuery;

class TemasProgramasController extends AppController
{

    public function index()
    {
        $query = $this->TemasProgramas->find()
            ->contain(['Programas']);
        $temasProgramas = $this->paginate($query);

        $this->set(compact('temasProgramas'));
    }


    // Asegúrate de importar esto arriba si no lo tienes


    // ... dentro de tu clase TemasProgramasController

    public function generarIa($id = null)
    {
        $this->request->allowMethod(['post', 'ajax']);

        $prompt = Configure::read('Prompts.liveShow');

        // 1. Obtener datos (igual que antes)
        /* $tema = $this->TemasProgramas->get($id, [
             'contain' => ['Programas']
         ]);*/
        $tema = $this->getTableLocator()->get('TemasProgramas')
            ->find()
            ->where(['TemasProgramas.ID' => $id])
            ->contain('Programas')
            ->first();

        // 2. Tu lógica de Prompt (Ya la tienes)

        $conduccion = $tema->programa->conduccion;
        $invitados = 'El|La|Los invitado(s) es|son: ' . $tema->invitados;
        $keywords = 'Algunas palabras claves que puedes usar para conocer el estilo o contenido del programa son: «' . $tema->tags . '».';
        // $tema = 'El tema a abordar es: «' . $tema->tema . '».';
        $prompt = str_replace(['%programa%', '%conduccion%', '%invitados%', '%tema%', '%keywords%'], [$tema->programa->name, $conduccion, $invitados, $tema->tema, $keywords], $prompt);


        // 3. Llamada al servicio (Simulación)
        // $respuestaIa = $this->GeminiService->ejecutar($prompt);

        // Suponemos que $respuestaIa es el string que devolvió Gemini
        // Si tu servicio devuelve un objeto, asegúrate de sacar solo el texto aquí.

        // 4. Devolución de String Puro
        return $this->response->withStringBody($prompt);
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
