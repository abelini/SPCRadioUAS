<?php
declare(strict_types=1);

namespace App;
/* Auth */
use Authentication\AuthenticationService;
use Authentication\AuthenticationServiceInterface;
use Authentication\AuthenticationServiceProviderInterface;
use Authentication\Identifier\AbstractIdentifier;
use Authentication\Identifier\IdentifierInterface;
use Authentication\Middleware\AuthenticationMiddleware;
use Cake\Routing\Router;
use Psr\Http\Message\ServerRequestInterface;
/* ---- */
use Cake\Core\Configure;
use Cake\Core\ContainerInterface;
use Cake\Datasource\FactoryLocator;
use Cake\Error\Middleware\ErrorHandlerMiddleware;
use Cake\Http\BaseApplication;
use Cake\Http\Middleware\BodyParserMiddleware;
use Cake\Http\Middleware\CsrfProtectionMiddleware;
use Cake\Http\MiddlewareQueue;
use Cake\ORM\Locator\TableLocator;
use Cake\Routing\Middleware\AssetMiddleware;
use Cake\Routing\Middleware\RoutingMiddleware;

/**
 * Application setup class.
 *
 * This defines the bootstrapping logic and middleware layers you
 * want to use in your application.
 *
 * @extends \Cake\Http\BaseApplication<\App\Application>
 */
class Application extends BaseApplication implements AuthenticationServiceProviderInterface {

	public function bootstrap(): void {
        // Call parent to load bootstrap from files.
		parent::bootstrap();
		
		$this->addPlugin('Authentication');
		
		if (PHP_SAPI !== 'cli') {
			FactoryLocator::add(
				'Table',
				(new TableLocator())->allowFallbackClass(false)
			);
		}
		Configure::write('DebugKit.safeTld', ['org']);
		Configure::write('DebugKit.variablesPanelMaxDepth', 8);
		
		Configure::write('CakePdf', ['engine' => 'CakePdf.CustomWkHtmlToPdf',]);
	}

	public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue {
		$middlewareQueue
			// Catch any exceptions in the lower layers,
			// and make an error page/response
			->add(new ErrorHandlerMiddleware(Configure::read('Error'), $this))

			// Handle plugin/theme assets like CakePHP normally does.
			->add(new AssetMiddleware([
				'cacheTime' => Configure::read('Asset.cacheTime'),
			]))

			// Add routing middleware.
			// If you have a large number of routes connected, turning on routes
			// caching in production could improve performance.
			->add(new RoutingMiddleware($this))

			// Parse various types of encoded request bodies so that they are
			// available as array through $request->getData()
			->add(new BodyParserMiddleware())

			// Cross Site Request Forgery (CSRF) Protection Middleware
			->add(new CsrfProtectionMiddleware([
				'httponly' => true,
			]))
			
			// Add the AuthenticationMiddleware. It should be
			// after routing and body parser.
			->add(new AuthenticationMiddleware($this));
			
		return $middlewareQueue;
	}

	public function getAuthenticationService(ServerRequestInterface $request): AuthenticationServiceInterface {
		$service = new AuthenticationService();

		// Define where users should be redirected to when they are not authenticated
		$service->setConfig([
			'unauthenticatedRedirect' => Router::url([
			    'prefix' => 'Admin',
			    'plugin' => null,
			    'controller' => 'Usuarios',
			    'action' => 'auth',
			]),
			'queryParam' => 'redirect',
		]);

		$fields = [
			AbstractIdentifier::CREDENTIAL_USERNAME => 'username',
			AbstractIdentifier::CREDENTIAL_PASSWORD => 'password'
		];
		// Load the authenticators. Session should be first.
		$service->loadAuthenticator('Authentication.Session');
		$service->loadAuthenticator('Authentication.Form', [
			'fields' => $fields,
			'loginUrl' => Router::url([
				'prefix' => 'Admin',
				'plugin' => null,
				'controller' => 'Usuarios',
				'action' => 'auth',
			]),
		]);

		// Load identifiers
		$service->loadIdentifier('Authentication.Password', [
			'fields' => [
				AbstractIdentifier::CREDENTIAL_USERNAME => 'username',
				AbstractIdentifier::CREDENTIAL_PASSWORD => 'password'
			],
			'resolver' => [
				'className' => 'Authentication.Orm',
				'userModel' => 'Usuarios',
				//'finder' => 'active', // default: 'all'
			],
		]);

		return $service;
	}

	public function services(ContainerInterface $container): void {
	}
}
