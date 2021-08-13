<?php

namespace Config;

class RouteConfig
{
    public static function getRouteConfig(): array
    {
        return [
            "/^\/$/" => "HomeController",
            "/^\/blog\/(?<slug>[a-zA-Z0-9-]+)$/" => "BlogController::index",
            "/^\/contact$/" => "ContactController::index",
            "/^\/propos$/" => "ProposController",
        ];
    }
}