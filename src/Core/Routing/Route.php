<?php

namespace App\Core\Routing;

class Route 
{
    public function __construct(private string $controller, private ?string $action = null, private array $params = [])
    {}

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