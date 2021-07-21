<?php

namespace Config;

class RouteConfig
{
    public static function getRouteConfig()
    {
        return [
            "/" => ["HomeController" => "index"],
            "/propos" => ["ProposController" => "index"]
        ];
    }
}