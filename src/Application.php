<?php

namespace App;

use Config\RouteConfig;
use App\Core\HttpFoundation\Request\Request;
use App\Core\Routing\Route;

class Application
{
    public function initialization() 
    {
        $request = new Request();
        $route = new Route();
        
        foreach (RouteConfig::getRouteConfig() as $patternRoute => $arrayClassFonction) 
        {
            if ($route->routeMatch($patternRoute, $request->getRequestUri())) 
            {
                foreach ($arrayClassFonction as $className => $functionName) 
                {
                    $className = "\App\Controller\\" . $className;

                    $instance = new $className();

                    call_user_func_array([$instance, $functionName], $route->getMatches());
                }
            }
        }
    }
    
}