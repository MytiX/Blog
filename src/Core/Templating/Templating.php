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

    /**
     * getView
     * Return the HTML template 
     * @param  string $file
     * @param  array $args
     * @return string
     */
    public function getView(string $file, array $args = []): string
    {
        if (!file_exists($this->configTemplate['path'].$file)) {
            throw new TemplatingException(sprintf('Incorrect file path : %s', $this->configTemplate['path'].$file), 500);
        }

        extract($args);

        ob_start();

        include $this->configTemplate['path'].$file;

        return ob_get_clean();
    }
}
