<?php

namespace App\Core\Routing;

use Config\RouteConfig;
use App\Core\Routing\Route;

class Router
{
    private $controllerNamespace = "\App\Controller\\";

    private $routes;

    private $controller; 

    private $action; 

    private $params; 

    public function __construct()
    {
        $this->routes = RouteConfig::getRouteConfig();
    }

    public function match(string $requestUri): ?Route 
    {
        foreach ($this->routes as $patternRoute => $arrayClassFonction) {

            if (preg_match($patternRoute, $requestUri, $matches)) {

                $controllerDefinition = explode('::', $arrayClassFonction);

                // Set le controller
                $this->setController($controllerDefinition[0]);

                // Set l'action
                
                if (count($controllerDefinition) > 1) {

                    // TODO Revoir les exceptions

                    // if (false === method_exists($controllerDefinition[0], $controllerDefinition[1])) {
                    //     throw new Exception("Error Processing Request", 1);
                    // }
                    $this->setAction($controllerDefinition[1]);
                }                
                
                // Set les params
                
                if (!is_null($matches)) {
                    $this->setParams($this->cleanMatches($matches));
                }

                return new Route($this->controller, $this->action, $this->params);
            }

        }

       return null;
    }

    private function setController(string $controller): void
    {
        $this->controller = $this->controllerNamespace . $controller;
    }

    private function setAction(string $action): void
    {
        $this->action = $action;
    }

    private function setParams(array $matches): void
    {
        $this->params = $matches;
    }

    private function cleanMatches(array $matches): array
    {
        foreach ($matches as $matche => $value) {

            if (is_numeric($matche)) {
                unset($matches[$matche]);
            }
        }

        return $matches;
    }
}
