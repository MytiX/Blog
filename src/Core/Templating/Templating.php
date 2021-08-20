<?php

namespace App\Core\Templating;

use App\Controller\ErrorController;
use Config\TemplatingConfig;

class Templating
{
    private array $configTemplate;

    public function __construct()
    {
        $this->configTemplate = TemplatingConfig::getConfig();
    }

    public function render(string $file, array $args = []) 
    {
        if (!file_exists($this->configTemplate["path"] . $file) ) {
            ErrorController::error404();
        }

        if (!is_null($args)) {
            extract($args);
        }

        ob_start();

        include $this->configTemplate["path"] . $file;

        $content = ob_get_clean();

        
        ob_start();

        include $this->configTemplate["base"];

        return ob_get_clean();
    }
}
