<?php

namespace App\Controller;

use App\Core\Controller\AbstractController;

class ErrorController extends AbstractController
{
    public function error404()
    {
        return $this->render("/error/404.php");
    }
}