<?php

namespace App;

use App\Controller\ErrorController;
use App\Core\HttpFoundation\Request\Request;
use App\Core\Routing\Route;
use Config\RouteConfig;

class Application
{
    public function initialization() 
    {
        $request = new Request();

        $requestUri = $request->getRequestUri();

        echo "<pre>";
        print_r($request);

    }
    // public function initialization() 
    // {
    //     $request = new Request();

    //     $requestUri = $request->getRequestUri();

    //     if (str_contains($requestUri, "?")) 
    //     {
    //         $options = substr($requestUri, strpos($requestUri, "?"));
    
    //         $requestUri = str_replace($options, "", $requestUri);
    //     }
    //     foreach (RouteConfig::getRouteConfig() as $keyRoute => $classFunction) 
    //     {
    //         if ($keyRoute == $requestUri) 
    //         {
    //             foreach ($classFunction as $className => $functionName) 
    //             {
    //                 $className = "\App\Controller\\" . $className;
    //                 $class = new $className();
    //                 call_user_func_array([$class, $functionName], [$id = 1, $nom = "jose"]);
    //                 exit;
    //             }
    //         }
    //     }
    //     ErrorController::error404();

    //     foreach (RouteConfig::getRouteConfig() as $keyRoute => $classFunction)
    //     {
    //         var_dump(Route::routeMatch($keyRoute, $requestUri));
    //     }

    // }
}