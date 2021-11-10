<?php

namespace App\Core\FormSecurity;

use Symfony\Component\HttpFoundation\Request;
use App\Core\FormSecurity\FormSecurityException\FormSecurityException;
use App\Core\FormSecurity\FormSecurityInterface\FormSecurityInterface;

abstract class FormSecurity implements FormSecurityInterface
{
    protected Request $request;

    protected array $configInput = [];

    protected array $requestParams = [];

    public function __construct()
    {
        $this->request = Request::createFromGlobals();
        $this->requestParams = $this->setRequestParams();
    }

    private function setRequestParams()
    {
        return $this->request->request->all();
    }

    public function isSubmit()
    {
        if ($this->request->getMethod() === "POST") {
            return true;
        }
        return false;
    }

    public function isValid()
    {
        // foreach ($this->requestParams as $inputName => $value) {

        //     // if (!in_array($inputName, $this->configInput)) {
        //     //     throw new FormSecurityException("You're fucking Input is broken", 500);
        //     // }
        // }
    }

    public function getData()
    {
        return $this->requestParams;
    }
}

