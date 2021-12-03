<?php

namespace App;

use App\Core\Route\Router;
use App\Controller\ErrorController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Core\Route\Exception\RouteMatchException;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
            $controllers = scandir('../src/Controller');

            unset($controllers[0], $controllers[1]);

            $this->router = new Router($controllers);

            if (($route = $this->router->getRoute()) === null) {
                throw new RouteMatchException('Page not found', 404);
            } else {
                $response = $this->executeController($route);
            }
        } catch (HttpExceptionInterface $e) {
            $response = $this->getExceptionResponse($e);
        }

        $response->send();
    }

    private function getExceptionResponse(HttpExceptionInterface $exception): Response
    {
        $errorController = new ErrorController();

        if (method_exists($errorController, 'error'.$exception->getStatusCode())) {
            return $errorController->{'error'.$exception->getStatusCode()}();
        }

        return $errorController->error($exception->getMessage(), $exception->getStatusCode());
    }

    private function executeController($route): Response|RedirectResponse
    {
        $controller = $route->getController();

        $controller->setRequest($this->request);
        return call_user_func_array([$controller, $route->getAction()], $route->getParams());
    }
}
