<?php

namespace App\Controller;

use App\Core\Controller\AbstractController;
use App\Core\HttpFoundation\Response\Response;

class ErrorController extends AbstractController
{
    public function error404(): Response
    {
        return $this->render("/error/404.php");
    }
}