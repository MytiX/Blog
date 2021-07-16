<?php

namespace App;

use App\Core\HttpFoundation\Response\Response;
use App\Core\HttpFoundation\Request\Request;

use ReflectionClass;

class Application
{
    public function getController() 
    {
        $request = new Request();

        $class = "\App\Controller\\" . ucfirst($request->get("action")) . "Controller";

        if (class_exists($class)) 
        {
            $controller = new $class();

            // var_dump(new ReflectionClass($controller));
    
            $controller->index();
        }
        else 
        {
            Response::redirect("home");
        }

    }
}