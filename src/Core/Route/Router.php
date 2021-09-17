<?php

namespace App\Core\Route;

use Config\RouteConfig;
use App\Core\Route\Route;
use App\Core\Route\Exception\RouteMatchException;

class Router
{
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
                
                // Set Classcontroller
                if (!class_exists($controllerDefinition[0])) {
                    throw new RouteMatchException("The class does not exist", 500);
                } else {
                    $this->setController($controllerDefinition[0]);
                }
                
                // Set function
                if (count($controllerDefinition) > 1) {
                    if (method_exists($controllerDefinition[0], $controllerDefinition[1]) === false) {
                        throw new RouteMatchException("The method does not exist in the Class", 500);
                    }
                    $this->setAction($controllerDefinition[1]);
                }                
                
                // Set params
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
        $this->controller = $controller;
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
