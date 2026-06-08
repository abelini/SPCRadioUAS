<?php

use Cake\Http\Exception\NotFoundException;
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

return function (RouteBuilder $routes): void {

    $routes->setRouteClass(DashedRoute::class);

    $routes->redirect('/radiodns/spi/3.1/SI.xml', [
        'prefix' => 'Api',
        'controller' => 'Schedule',
        'action' => 'si'
    ]);

    $routes->connect('/radiodns/spi/3.1/radiouas/{date}', [
        'prefix' => 'Api',
        'controller' => 'Schedule',
        'action' => 'pi',
    ])->setPatterns(['date' => '[0-9]{8}_PI\.xml']);

    $routes->prefix('Admin', function (RouteBuilder $routes) {
        $routes->fallbacks(DashedRoute::class);
    });

    $routes->prefix('Api', function (RouteBuilder $routes) {
        $routes->setExtensions(['json']);

        $routes->connect('/hits/add', [
            'controller' => 'StreamHits',
            'action' => 'add'
        ], ['_method' => 'POST']);

        // Metadata endpoints
        $routes->connect('/metadata/update', [
            'controller' => 'Metadata',
            'action' => 'update'
        ], ['_method' => 'POST']);

        // Schedule endpoints
        $routes->connect('/schedule/now', [
            'controller' => 'Schedule',
            'action' => 'now'
        ], ['_method' => 'GET']);

        $routes->connect('/locutores', [
            'controller' => 'Locutores',
            'action' => 'index'
        ], ['_method' => 'GET']);

        $routes->connect('/cabina/locutor', [
            'controller' => 'Locutores',
            'action' => 'index'
        ], ['_method' => 'GET']);

        $routes->connect('/programas/list', [
            'controller' => 'Programas',
            'action' => 'list'
        ], ['_method' => 'GET']);

        // Catch-all for unmatched routes (no fallbacks!)
        $routes->connect('/{controller}/{action}', [
            'controller' => 'Error',
            'action' => 'error404'
        ]);
    });

    $routes->scope('/', function (RouteBuilder $builder): void {
        /*
         * Here, we are connecting '/' (base path) to a controller called 'Pages',
         * its action called 'display', and we pass a param to select the view file
         * to use (in this case, templates/Pages/home.php)...
         */
        $builder->connect('/', ['controller' => 'Pages', 'action' => 'display', 'home']);
        $builder->connect('/admin', ['controller' => 'Dashboard', 'action' => 'index', 'prefix' => 'Admin']);
        /*
         * ...and connect the rest of 'Pages' controller's URLs.
         */
        $builder->connect('/pages/*', 'Pages::display');
        $builder->connect('/bitacora/cabina/*', 'BitacoraCabina::display');
        $builder->connect('/bitacora/vigilancia/*', 'Incidencias::add');

        $builder->connect('/topics', 'TemasProgramas::index');
        $builder->connect('/topics/add', 'TemasProgramas::add');

        /*
         * Connect catchall routes for all controllers.
         *
         * The `fallbacks` method is a shortcut for
         *
         * ```
         * $builder->connect('/{controller}', ['action' => 'index']);
         * $builder->connect('/{controller}/{action}/*', []);
         * ```
         *
         * You can remove these routes once you've connected the
         * routes you want in your application.
         */
        $builder->fallbacks();
    });

    /*
     * If you need a different set of middleware or none at all,
     * open new scope and define routes there.
     *
     * ```
     */

};
