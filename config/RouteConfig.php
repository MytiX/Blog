<?php

namespace Config;

class RouteConfig
{
    public static function getRouteConfig(): array
    {
        return [
            "/^\/$/" => "HomeController",
            // "/^\/blog$/" => "BlogController::viewAllPosts",
            "/^\/blog\/(?<slug>[a-zA-Z0-9-]+)$/" => "BlogController::viewPos",
        ];
    }
}