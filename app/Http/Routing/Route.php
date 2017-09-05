<?php
namespace App\Http\Routing;

use DI\Container;
use FastRoute\RouteCollector;
use FastRoute\Dispatcher;
use function FastRoute\simpleDispatcher;
use App\Services\Session\PhpSession;

class Route{

    public function dispatch( $verb, $uri, Container $container, PhpSession $session ){

        $this->checkAppSession($session);

        $dispatcher = simpleDispatcher(function (RouteCollector $r) {
            require_once(  __DIR__ . '/routes.php' );
        });

        $route = $dispatcher->dispatch($verb, $uri);

        switch ($route[0]) {
            case Dispatcher::NOT_FOUND:
                return '404 Not Found';
            break;

            case Dispatcher::METHOD_NOT_ALLOWED:
                return '405 Method Not Allowed';
            break;

            case Dispatcher::FOUND:
                $controller = $route[1];
                $parameters = $route[2];

                // We could do $container->get($controller) but $container->call()
                // does that automatically
                return $container->call($controller, $parameters);
            break;
        }
    }

    private function checkAppSession(PhpSession $session){

        $session->start();
        $session->checkAuthenticationStatus();
    }
}
