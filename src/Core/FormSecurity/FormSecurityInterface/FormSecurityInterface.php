<?php

namespace App\Core\FormSecurity\FormSecurityInterface;

interface FormSecurityInterface
{
    public function __construct();

    public function isSubmit();

    public function isValid();

    public function getData();
}

