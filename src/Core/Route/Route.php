<?php

namespace App\Core\Route;

use Attribute;

#[Attribute]
class Route
{
    private string $path;

    private $controller;

    private string $action;

    private array $params = [];

    private array $roles = [];

    public function __construct(string $path, array $roles = [])
    {
        $this->path = $path;
        $this->roles = $roles;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setController(string $controller): void
    {
        $this->controller = new $controller();
    }

    public function getController()
    {
        return $this->controller;
    }

    public function setAction(string $action): void
    {
        $this->action = $action;
    }

    public function getAction()
    {
        return $this->action;
    }

    public function setParams(array $matches): void
    {
        $this->params = $matches;
    }

    public function getParams(): array
    {
        return $this->params;
    }
}
