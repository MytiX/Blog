<?php

namespace App\Controller;

use App\Core\Controller\AbstractController;
use App\Core\HttpFoundation\Response\Response;

class ErrorController extends AbstractController
{
    public function error404(): Response
    {
        return $this->render('/error/404.php', [], 404);
    }

    // public function error500(): Response
    // {
    //     return $this->render("/error/500.php", [], 500);
    // }

    public function error(string $message, int $statusCode): Response
    {
        return $this->render('/error/error.php', [
            'errorMessage' => $message,
        ], $statusCode);
    }
}
