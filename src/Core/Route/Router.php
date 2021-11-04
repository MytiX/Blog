<?php

namespace App\Core\Route;

use ReflectionClass;
use Symfony\Component\HttpFoundation\Request;

class Router
{
    private Request $request;

    private array $controllers;

    public const DELIMITER = '/';

    public function __construct(array $controllers)
    {
        $this->controllers = $controllers;
        $this->request = Request::createFromGlobals();
    }

    public function getRoute(): ?Route
    {
        foreach ($this->controllers as $fichier) {
            $className = "App\Controller\\".str_replace('.php', '', $fichier);

            $reflection = new ReflectionClass($className);

            foreach ($reflection->getMethods() as $method) {
                $routeAttributes = $method->getAttributes();

                foreach ($routeAttributes as $routeAttribute) {
                    $arguments = $routeAttribute->getArguments();

                    /** @var Route $route */
                    $route = $routeAttribute->newInstance();

                    if ($route->getPath() === $this->request->getRequestUri()) {
                        $route->setController($className);
                        $route->setAction($method->getName());

                        return $route;
                    }

                    $regex = $this->getParamsRegex($route);

                    if (null !== $regex) {
                        if (preg_match($regex, $this->request->getRequestUri(), $matches)) {
                            $route->setController($className);
                            $route->setAction($method->getName());
                            // Set params
                            if (!is_null($matches)) {
                                $route->setParams($this->cleanMatches($matches));
                            }

                            return $route;
                        }
                    }
                }
            }
        }

        return null;
    }

    private function getParamsRegex(Route $route): ?string
    {
        if (preg_match_all('/{[a-zA-Z0-9-]+}/', $route->getPath(), $matches)) {
            $regex = $route->getPath();

            foreach ($matches[0] as $matche) {
                $matcheFormate = str_replace('{', '', $matche);
                $matcheFormate = str_replace('}', '', $matcheFormate);

                $regexMatche = '(?<'.$matcheFormate.'>[a-zA-Z0-9-]+)';

                $regex = str_replace($matche, $regexMatche, $regex);
            }

            return self::DELIMITER.str_replace('/', "\/", $regex).self::DELIMITER;
        }

        return null;
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
