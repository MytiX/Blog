<?php

namespace App\Core\FormSecurity\FormSecurityInterface;

use Symfony\Component\HttpFoundation\Request;

interface FormSecurityInterface
{
    public function __construct(Request $request);

    public function isSubmit();

    public function isValid();

    public function getData();
}

