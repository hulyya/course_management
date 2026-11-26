<?php
namespace src\app\core;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use src\app\controller\CourseController;

class Routing{
    public function start(Request $request):Response{
        
        $routes = new RouteCollection();

        $routes->add('login', new Route('/login', [
            '_controller' => [Auth::class, 'login']
        ], methods: ['GET', 'POST']));
        // in routes.php werfen
        $routes->add('admin/course', new Route('/admin/course', [
            '_controller' => [CourseController::class, 'adminListCourseSite']
        ], methods: ['GET', 'POST']));
        
        $routes->add('admin/course/delete', new Route('/admin/course/delete/{id}', [
            '_controller' => [CourseController::class, 'deleteCourse']
        ], methods: ['GET', 'POST']));

        
        
        $routes->add('admin/course/edit', new Route('/admin/course/edit/{id}', [
        '_controller' => [CourseController::class, 'adminCourseSite']
        ], methods: ['GET']));

        $routes->add('admin/course/edit/save', new Route('/admin/course/save/{id}', [
        '_controller' => [CourseController::class, 'adminCourseSite']
        ], methods: ['POST']));
        

        

        $context = new RequestContext();
        $context->fromRequest($request);
        $matcher = new UrlMatcher($routes, $context);

        try {
            $parameters = $matcher->match($request->getPathInfo());

            [$controllerClass, $methodName] = $parameters['_controller'];
            unset($parameters['_controller'], $parameters['_route']);

            $response = (new $controllerClass())->$methodName($request, ...$parameters);

            if (!$response instanceof Response) {
                return new Response((string) $response);
            }
            return $response;

        } catch (ResourceNotFoundException $e) {
            return new Response('404 - Seite nicht gefunden', Response::HTTP_NOT_FOUND);
        } catch (MethodNotAllowedException $e) {
            return new Response('405 - HTTP-Methode nicht erlaubt', Response::HTTP_METHOD_NOT_ALLOWED);
        } catch (\Exception $e) {
            return new Response('500 - Fehler: ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}