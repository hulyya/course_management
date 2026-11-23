<?php
namespace src\app\core;

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;


use src\app\controller\CourseController;

class Routing{

    public function start():void{

        $routes = new RouteCollection();

        $routes->add('admin', new Route('/admin',[
            '_controller'   => CourseController::class,
            '_method'       => 'adminSite', 
        ], 
        methods:['GET', 'POST'] //wenn adminSite formulare absendet auch POST
        ));
        
        $context = new RequestContext();
        $context->setMethod($_SERVER['REQUEST_METHOD']);

        $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        $basePaths = [
            '/course_management/public/index.php',
            '/course_management/public'
        ];

        foreach ($basePaths as $basePath) {
            if (str_starts_with($currentPath, $basePath)) {
                $currentPath = substr($currentPath, strlen($basePath)) ?: '/';
                break;
            }
        }

        $matcher = new UrlMatcher($routes, $context);
        try {
            $parameters = $matcher->match($currentPath);

            $controllerClass = $parameters['_controller'];
            $methodName      = $parameters['_method'];

            unset($parameters['_controller'], $parameters['_method'], $parameters['_route']);

            $controller = new $controllerClass();
            $controller->$methodName(...$parameters);

        } catch (ResourceNotFoundException $e) {
            http_response_code(404);
            echo "404 - Seite nicht gefunden";
        } catch (MethodNotAllowedException $e) {
            http_response_code(405);
            echo "405 - Methode nicht erlaubt";
        }
    }
}