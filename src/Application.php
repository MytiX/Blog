<?php

namespace App;

use App\Controller\ErrorController;
use App\Core\HttpFoundation\Request\Request;
use Config\RouteConfig;

class Application
{
    public function initialization() 
    {
        $request = new Request();

        $requestUri = $request->getRequestUri();

        if (str_contains($requestUri, "?")) 
        {
            $options = substr($requestUri, strpos($requestUri, "?"));
    
            $requestUri = str_replace($options, "", $requestUri);
        }
        
        foreach (RouteConfig::getRouteConfig() as $keyRoute => $classFunction) 
        {
            if ($keyRoute == $requestUri) 
            {
                foreach ($classFunction as $className => $functionName) 
                {
                    $className = "\App\Controller\\" . ucfirst($className);
                    $class = new $className();
                    call_user_func_array([$class, $functionName], []);
                    exit;
                }
            }
        }
        ErrorController::error404();
    }
}