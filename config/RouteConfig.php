<?php

namespace Config;

class RouteConfig
{
    public static function getRouteConfig()
    {
        return [
            "^\/blog\/(?<slug>[a-zA-Z0-9]+)$" => ["HomeController" => "test"],
            "^\/user\/contact$" => ["ContactController" => "index"],
            "^\/propos$" => ["ProposController" => "index"],
        ];
    }
}