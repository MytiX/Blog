<?php

namespace App\Core\Route;

class Route 
{

    private string $controller;

    private ?string $action;

    private array $params;

    public function __construct(string $controller, ?string $action = null, array $params = [])
    {
        $this->controller = $controller;
        $this->action = $action;
        $this->params = $params;
    }

    public function getInstance(): mixed
    {
        if ($this->action === null) {
            $instance = new $this->controller();
        } else {
            $instance = [new $this->controller, $this->action];
        }

        return $instance;
    }

    public function getParams(): array
    {
        return $this->params;
    }
}