<?php

namespace App\Core\Controller;

use App\Core\HttpFoundation\Response\Response;
use App\Core\Templating\Templating;

abstract class AbstractController
{
    protected function render(string $file, array $args = [], int $statusCode = 200)
    {
        $template = new Templating();

        return new Response($template->getView($file, $args), $statusCode);
    }
}
