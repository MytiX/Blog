<?php

namespace App\Core\Routing;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD|Attribute::TARGET_CLASS)]
class Route 
{
    public string $route;

    public function __construct(private string $path, private string $method) {} 

    public function getPath(): string
    {
        return $this->path;
    }

    public function getMethod(): string
    {
        return $this->method;
    }
}