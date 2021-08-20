<?php

namespace App;

use App\Controller\ErrorController;
use App\Core\Routing\Router;
use App\Core\HttpFoundation\Request\Request;

class Application
{
    public function initialization(): void
    {
        $request = new Request();
        $router = new Router();

        if (null === ($route = $router->match($request->getRequestUri()))) {
            ErrorController::error404();
        }

        $response = call_user_func_array($route->getInstance(), $route->getParams());

        $response->send();
    }
    
}