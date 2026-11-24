<?php
namespace src\app\core;

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use src\app\controller\CourseController;

class Routing
{
    public function start(): void
    {
        $routes = new RouteCollection();

        $routes->add('admin', new Route('/admin', [
            '_controller' => [CourseController::class, 'adminSite']
        ], methods: ['GET', 'POST']));
        
        $routes->add('login', new Route('/login', [
            '_controller' => [Auth::class, 'login']
        ], methods: ['GET', 'POST']));

        

        $currentPath = $_SERVER['PATH_INFO'] ?? '/';

        $context = new RequestContext(method: $_SERVER['REQUEST_METHOD']);
        $matcher = new UrlMatcher($routes, $context);

        try {
            $parameters = $matcher->match($currentPath);

            [$controllerClass, $methodName] = $parameters['_controller'];
            unset($parameters['_controller'], $parameters['_route']);

            echo (new $controllerClass())->$methodName(...$parameters);

        } catch (\Exception $e) {
            http_response_code(404);
            echo "404 - Seite nicht gefunden";
            echo "Fehler: " . $e->getMessage();

        }
    }
}
