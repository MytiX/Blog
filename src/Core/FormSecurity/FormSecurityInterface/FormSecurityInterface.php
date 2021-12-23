<?php

namespace App\Core\FormSecurity\FormSecurityInterface;

use App\Core\Session\Session;
use Symfony\Component\HttpFoundation\Request;

interface FormSecurityInterface
{
    public function __construct(Request $request, Session $session);

    public function isSubmit();

    public function isValid();

    public function getData();
}

