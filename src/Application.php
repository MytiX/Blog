<?php

namespace App;

use App\Core\Route\Router;
use App\Controller\ErrorController;
use App\Core\HttpFoundation\Request\Request;
use App\Core\HttpFoundation\Response\Response;
use App\Core\Route\Exception\RouteMatchException;
use App\Core\HttpFoundation\HttpFoundationInterface\HttpFoundationInterface;

class Application
{
    private $request;
    
    private $router;

    public function __construct()
    {
        $this->request = Request::createFromGlobals();
        
        $this->router = new Router();

        $this->error = new ErrorController();
    }

    public function initialization(): void
    {
        try {
            if (($route = $this->router->match($this->request->getRequestUri())) === null) {
                throw new RouteMatchException("Page not found", 404);
            } else {
                $response = call_user_func_array($route->getInstance(), $route->getParams());
            }
        } catch (HttpFoundationInterface $e) {
            $response = $this->getExceptionResponse($e);
        }
        
        $response->send();
    }

    private function getExceptionResponse(HttpFoundationInterface $exception): Response
    {
        if ($exception->getStatusCode() === 404) {
            $errorController = new ErrorController();
            return $errorController->error404();
        } else {
            return new Response($exception->getMessage(), $exception->getStatusCode());
        }
    }
    
}