<?php

namespace App\Core\Templating;

use App\Controller\ErrorController;
use App\Core\Templating\TemplatingException\TemplatingException;
use Config\TemplatingConfig;

class Templating
{
    private array $configTemplate;

    public function __construct()
    {
        $this->configTemplate = TemplatingConfig::getConfig();

        $this->error = new ErrorController();
    }

    public function getView(string $file, array $args = []) 
    {
        if (!file_exists($this->configTemplate["path"] . $file) ) {
            throw new TemplatingException("Incorrect file path : " . $this->configTemplate["path"] . $file, 500);
        }

        if (!is_null($args)) {
            extract($args);
        }

        ob_start();

        include $this->configTemplate["path"] . $file;

        return ob_get_clean();
    }
}
