<?php

namespace App\Controller;

use App\Core\Route\Route;
use App\Core\Controller\AbstractController;

class ValidateAccount extends AbstractController
{
    #[Route('/validate-account')]
    public function validEmail()
    {
        dd($this->getRequest());
    }
}
