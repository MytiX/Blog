<?php

namespace App;

use App\Controller\ErrorController;
use App\Core\Routing\Router;
use App\Core\HttpFoundation\Request\Request;

class Application
{
    private $request;
    
    private $router;

    private $error;

    public function __construct()
    {
        $this->request = new Request();
        
        $this->router = new Router();

        $this->error = new ErrorController();
    }

    public function initialization(): void
    {
        if (($route = $this->router->match($this->request->getRequestUri())) === null) {
            $response = $this->error->error404();
        } else {
            
            // TODO Comment ne pas avoir l'erreur PHP afficher mais plutôt une 404 si la function ou la class n'existe pas ???
            if (($response = call_user_func_array($route->getInstance(), $route->getParams())) === false) {
                // TODO Faire plutôt un render du controller 404 sur l'url indiquer ou rediriger sur le controller 404 avec l'url du controller 404 ???
                $response = $this->error->error404();
            }
        }

        $response->send();
    }
    
}