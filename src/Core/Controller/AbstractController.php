<?php

namespace App\Core\Controller;

use App\Core\Templating\Templating;
use App\Core\HttpFoundation\Response\Response;

abstract class AbstractController
{
    protected function render(string $file, array $args = [], int $statusCode = 200)
    {
        $template = new Templating();

        return new Response($template->getView($file, $args), $statusCode);
    }
}