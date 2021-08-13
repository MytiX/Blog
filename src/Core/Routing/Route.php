<?php

namespace App\Core\Routing;

use App\Core\HttpFoundation\Request\Request;
use Config\RouteConfig;

class Route 
{
    private $matches;

    public function routeMatch(string $patternUri, string $requestUri)
    {
        if (preg_match("/" . $patternUri . "/", $requestUri, $matches)) 
        {
            if (!is_null($matches)) 
            {
                foreach ($matches as $matche => $value) 
                {
                    if (is_numeric($matche)) 
                    {
                        unset($matches[$matche]);
                    }
                }

                $this->setMatches($matches);
            }

            return true;
        }

        return false;
    }

    private function setMatches($matches) 
    {
        $this->matches = $matches;
    }

    public function getMatches() 
    {
        return $this->matches;
    }
}