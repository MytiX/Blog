<?php

namespace App\Core\Route;

use Attribute;

#[Attribute]
class Route
{
    private string $path;

    private string $controller;

    private string $action;

    private array $params = [];

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setController(string $controller): void
    {
        $this->controller = $controller;
    }

    public function setAction(string $action): void
    {
        $this->action = $action;
    }

    public function setParams(array $matches): void
    {
        $this->params = $matches;
    }

    public function getInstance(): mixed
    {
        return [new $this->controller(), $this->action];
    }

    public function getParams(): array
    {
        return $this->params;
    }
}