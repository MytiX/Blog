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

    /**
     * getPath
     * Return path in Attributes Route
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * getRoles
     * Return role in Attributes Route
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * setController
     * Initialisation class controller
     * @param  string $controller
     * @return void
     */
    public function setController(string $controller): void
    {
        $this->controller = new $controller();
    }

    /**
     * getController
     * Return instance of Controller
     * @return object
     */
    public function getController(): object
    {
        return $this->controller;
    }

    /**
     * setAction
     * Set function of controller
     * @param  string $action
     * @return void
     */
    public function setAction(string $action): void
    {
        $this->action = $action;
    }

    /**
     * getAction
     * Return name of the function to execute in controller
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * setParams
     * Set params of the function
     * @param  array $matches
     * @return void
     */
    public function setParams(array $matches): void
    {
        $this->params = $matches;
    }

    /**
     * getParams
     * Return params of the function
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }
}
