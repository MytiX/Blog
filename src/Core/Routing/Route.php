<?php

namespace App\Core\Routing;

class Route 
{
    public static function routeMatch(string $patternUri, string $uri)
    {
        
        if (preg_match("/" . $patternUri . "/", $uri, $match)) 
        {
            return $match;
        }
        
        return false;
        
    }
}