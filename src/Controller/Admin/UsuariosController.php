<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\AppController;
use Authentication\Authenticator\ResultInterface;
use Cake\Event\EventInterface;
use Cake\Http\Response;
use Cake\Mailer\MailerAwareTrait;


class UsuariosController extends AppController {
	
	use MailerAwareTrait;
	
	public function beforeFilter(EventInterface $event) {
		parent::beforeFilter($event);
		$this->Authentication->allowUnauthenticated(['auth', 'retrieve']);
	}
	
	public function auth() {
		$result = $this->Authentication->getResult();
		// If the user is logged in send them away.
		if ($result->isValid()) {
			$target = match($this->Authentication->getLoginRedirect()) {
				'/', null => '/admin/dashboard',
				default => $this->Authentication->getLoginRedirect(),
			};
			return $this->redirect($target);
		}
		if ($this->request->is('post')) {
			$message = match($result->getStatus()) {
				ResultInterface::FAILURE_IDENTITY_NOT_FOUND => 'El usuario no existe',
				default => 'Error de autenticación',
			};
			$this->Flash->error($message);
			$this->set('retrieveLink', true);
			//$this->Flash->error('Invalid username or password');
		}
	}
	
	public function retrieve() : Response {
		if($this->request->is('post')) {

			$id = $this->request->getData('identifier');
			
			if(filter_var($id, FILTER_VALIDATE_EMAIL)) {
				$condition = ['email' => $id];
			}
			else {
				$condition = ['username' => $id];
			}
			
			$user = $this->Usuarios
						->find()
						->where($condition)
						->first();
							
			if($user === null){
				$this->Flash->error('El nombre o correo proporcionado no está registrado en la plataforma');
				return $this->render();
			}
			$password = $user->generateAndSetPassword();
			if($this->Usuarios->save($user)){
				//$this->getMailer('User')->resetPassword($user, $password, parent::$title);
				$this->Flash->success('Se te generó una contraseña nueva: '. $password );
			} else {
				$this->Flash->error('Error. Por favor, intenta nuevamente en un momento.');
			}
			return $this->redirect(['action' => 'login']);
		}
		return $this->render();
	}
	
	
	public function logout() {
		$this->Authentication->logout();
		return $this->redirect('/');
	}

	public function index() {
		$query = $this->Usuarios->find();
		$usuarios = $this->paginate($query);
		
		$permisos = $this->Usuarios->Permisos->find()
										->contain('Usuarios')
										->all();
		
		$this->set(compact('usuarios', 'permisos'));
	}

    /**
     * View method
     *
     * @param string|null $id Usuario id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $usuario = $this->Usuarios->get($id, contain: ['Permisos']);
        $this->set(compact('usuario'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $usuario = $this->Usuarios->newEmptyEntity();
        if ($this->request->is('post')) {
            $usuario = $this->Usuarios->patchEntity($usuario, $this->request->getData());
            if ($this->Usuarios->save($usuario)) {
                $this->Flash->success(__('The usuario has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The usuario could not be saved. Please, try again.'));
        }
        $permisos = $this->Usuarios->Permisos->find('list', limit: 200)->all();
        $this->set(compact('usuario', 'permisos'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Usuario id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
	public function edit($id = null) {
		$usuario = $this->Usuarios->get($id, contain: ['Permisos']);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$usuario = $this->Usuarios->patchEntity($usuario, $this->request->getData());// debug($usuario);exit();
			if ($this->Usuarios->save($usuario)) {
				$this->Flash->success(__('The usuario has been saved.'));
				//$this->getMailer('User')->send('welcome', [$usuario]);
				//$this->getMailer('Rol')->new($rol);
				return $this->redirect(['action' => 'index']);
			}
			else $this->Flash->error(__('The usuario could not be saved. Please, try again.'));
		}
		$permisos = $this->Usuarios->Permisos->find('list', limit: 200)->all();
		$this->set(compact('usuario', 'permisos'));
	}

    /**
     * Delete method
     *
     * @param string|null $id Usuario id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $usuario = $this->Usuarios->get($id);
        if ($this->Usuarios->delete($usuario)) {
            $this->Flash->success(__('The usuario has been deleted.'));
        } else {
            $this->Flash->error(__('The usuario could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
