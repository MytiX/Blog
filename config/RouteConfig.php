<?php

namespace Config;

class RouteConfig
{
    public static function getRouteConfig(): array
    {
        return [
            "/^\/$/" => "App\Controller\HomeController",
            "/^\/blog$/" => "App\Controller\BlogController::viewAllPosts",
            "/^\/blog\/(?<slug>[a-zA-Z0-9-]+)$/" => "App\Controller\BlogController::viewPost",
        ];
    }
}