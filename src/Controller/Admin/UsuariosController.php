<?php
declare(strict_types=1);

namespace SPC\Controller\Admin;

use SPC\Controller\AppController;
use Authentication\Authenticator\ResultInterface;
use Cake\Event\EventInterface;
use Cake\Http\Cookie\Cookie;
use Cake\Http\Response;
use Cake\Mailer\MailerAwareTrait;


class UsuariosController extends AppController
{

	use MailerAwareTrait;

	public function beforeFilter(EventInterface $event)
	{
		parent::beforeFilter($event);
		$this->Authentication->allowUnauthenticated(['auth', 'retrieve', 'setTheme']);
	}

	public function auth(): Response
	{
		$result = $this->Authentication->getResult();

		if ($result->isValid()) {
			if (!$this->request->getCookie('Theme')) {
				$this->response = $this->response->withCookie(new Cookie('Theme', 'midday', parent::$datetime->addDays(30)));
			}
			return $this->Authentication->redirectAfterLogin();
		}
		if ($this->request->is('post')) {
			$message = match ($result->getStatus()) {
				ResultInterface::FAILURE_IDENTITY_NOT_FOUND => 'Credenciales inválidas',
				ResultInterface::FAILURE_CREDENTIALS_MISSING => 'Por favor rellene todos los campos',
				ResultInterface::FAILURE_CREDENTIALS_INVALID => 'Credenciales inválidas',
				default => 'Error de autenticación',
			};
			$this->Flash->error($message);
			$this->set('retrieveLink', true);

			return $this->render();
		}

		return $this->render();
	}

	public function retrieve(): Response
	{
		if ($this->request->is('post')) {

			$identifier = $this->request->getData('identifier');

			if (!filter_var($identifier, FILTER_VALIDATE_EMAIL) && !ctype_alpha($identifier)) {
				$this->Flash->error('El nombre o correo proporcionado no es válido');
				return $this->render();
			}

			$user = $this->Usuarios->findAllByUsernameOrEmail($identifier, $identifier)->first();

			if ($user === null) {
				$this->Flash->error('El nombre o correo proporcionado no está registrado en la plataforma');
				return $this->render();
			}
			$password = $user->generateAndSetPassword();
			if ($this->Usuarios->save($user)) {
				$this->getMailer('User')->resetPassword($user, $password, parent::APP_NAME);
				$this->Flash->success('Se te generó una contraseña nueva. Revisa tu correo.');
			} else {
				$this->Flash->error('Error. Por favor, intenta nuevamente en un momento.');
			}
			return $this->render('auth');
		}
		return $this->render();
	}

	public function setTheme(): Response
	{
		$theme = $this->request->getData('theme');
		$this->response = $this->response->withCookie(new Cookie('Theme', $theme, parent::$datetime->addDays(30)));
		return $this->redirect($this->request->referer());
	}


	public function logout()
	{
		$this->Authentication->logout();
		return $this->redirect('/');
	}

	public function index()
	{
		$query = $this->Usuarios->find();
		$usuarios = $this->paginate($query);

		$permisos = $this->Usuarios->Permisos->find()
			->contain('Usuarios')
			->all();

		$this->set(compact('usuarios', 'permisos'));
	}

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
	public function edit($id = null)
	{
		$usuario = $this->Usuarios->get($id, contain: ['Permisos']);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$usuario = $this->Usuarios->patchEntity($usuario, $this->request->getData());// debug($usuario);exit();
			if ($this->Usuarios->save($usuario)) {
				$this->Flash->success(__('The usuario has been saved.'));
				//$this->getMailer('User')->send('welcome', [$usuario]);
				//$this->getMailer('Rol')->new($rol);
				return $this->redirect(['action' => 'index']);
			} else
				$this->Flash->error(__('The usuario could not be saved. Please, try again.'));
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

	public function profile(): Response
	{
		$user = $this->Usuarios->find()
			->select(['ID', 'empleado', 'username', 'name', 'fullname', 'email', 'base', 'photo'])
			->where(['ID' => $this->Authentication->getIdentity()->get('ID')])
			->first();

		if ($this->request->is(['patch', 'post', 'put'])) {
			$data = $this->request->getData();

			if (!empty($data['new_password'])) {
				if ($data['new_password'] !== $data['confirm_password']) {
					$this->Flash->error('Las contraseñas no coinciden');
					$this->set(compact('user'));
					return $this->render();
				}
				$data['password'] = $data['new_password'];
			}

			unset($data['new_password'], $data['confirm_password']);

			$user = $this->Usuarios->patchEntity($user, $data);

			if ($this->Usuarios->save($user)) {
				$this->Flash->success('Perfil actualizado correctamente');
				return $this->redirect(['action' => 'profile']);
			} else {
				$this->Flash->error('Error al actualizar. Verifica los datos.');
			}
		}

		$this->set(compact('user'));
		return $this->render();
	}
}

