<?php

namespace App\Controller;

use App\Core\Routing\Route;

#[Route("test")]
class ProposController 
{
    #[Route("test")]
    public function index() 
    {

        echo "ProposController";
    }
}