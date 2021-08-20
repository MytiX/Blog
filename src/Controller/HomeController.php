<?php

namespace App\Controller;

use App\Core\HttpFoundation\Response\Response;
use App\Core\Templating\Templating;
use Config\TemplatingConfig;

class HomeController 
{
    public function __invoke()
    {
        $template = new Templating();

        return new Response($template->render("/home/home.php", [
            "test" => "Robert",
        ]));
    }
}