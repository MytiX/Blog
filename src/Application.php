<?php

namespace App;

use App\Core\Route\Router;
use App\Controller\ErrorController;
use App\Core\HttpFoundation\Request\Request;
use App\Core\HttpFoundation\Response\Response;
use App\Core\Route\Exception\RouteMatchException;
use App\Core\HttpFoundation\Exception\HttpExceptionInterface;

class Application
{    
    private Router $router;

    public function __construct()
    {
        $this->request = Request::createFromGlobals();
    }

    public function initialization(): void
    {
        try {

            $controllers = scandir("../src/Controller");

            unset($controllers[0], $controllers[1]);

            $this->router = new Router($controllers);

            if (($route = $this->router->getRoute()) === null) {
                throw new RouteMatchException("Page not found", 404);
            } else {
                $response = call_user_func_array($route->getInstance(), $route->getParams());
            }
        } catch (HttpExceptionInterface $e) {
            $response = $this->getExceptionResponse($e);
        }
        
        $response->send();
    }

    private function getExceptionResponse(HttpExceptionInterface $exception): Response
    {
        $errorController = new ErrorController();

        if (method_exists($errorController, 'error' . $exception->getStatusCode())) {
            return $errorController->{'error' . $exception->getStatusCode()}();
        }

        return $errorController->error($exception->getMessage(), $exception->getStatusCode());
    }
    
}