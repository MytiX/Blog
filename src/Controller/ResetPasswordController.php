<?php

namespace App\Controller;

use App\Core\Controller\AbstractController;
use App\Core\Route\Route;
use Symfony\Component\HttpFoundation\Response;

class ResetPasswordController extends AbstractController
{
    #[Route('/reset-password')]
    public function resetPassword(): Response
    {
        dd('ICI');
    }
}
