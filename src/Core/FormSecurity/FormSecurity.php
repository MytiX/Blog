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

    protected array $formErrors = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->setRequestParams();
    }

    private function setRequestParams(): void
    {
        $this->requestParams = $this->request->request->all();
    }

    private function getRequestParams(): array
    {
        return $this->requestParams;
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
        foreach ($this->getRequestParams() as $inputName => $value) {

            if (key_exists($inputName, $this->configInput)) {
                if ($this->configInput[$inputName]['isNull'] === false) {
                    if (!empty($value)) {
                        $this->setErrors($inputName, $this->configInput[$inputName]['errorMessage']);
                    }
                }
                // TODO checker les messages d'erreurs
                if (!preg_match($this->configInput[$inputName]['constraint'], $value)) {
                    // return message d'erreur
                    dd("preg match pas bon pour $inputName");
                }
            } else {
                dd('Throw la clé n\'existe pas');
            }
        }
        if (!empty($this->getErrors())) {
            return false;
        }
        return true;
    }

    public function setErrors($key, $message): void
    {
        $this->formErrors[$key] = $message;
    }
    public function getErrors(): array
    {
        return $this->formErrors;
    }

    public function getData()
    {
        return $this->requestParams;
    }
}

