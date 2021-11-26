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

    protected string $isNullError = 'Le champs ne peux pas être vide';

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
            if (array_key_exists($inputName, $this->configInput)) {
                $inputConfig = $this->configInput[$inputName];

                if (empty($value) && array_key_exists('isNull', $inputConfig) && true !== $inputConfig['isNull']) {
                    $this->setMessages($inputName, $this->isNullError);
                    continue;
                }

                if (array_key_exists('constraint', $inputConfig) && !preg_match($inputConfig['constraint'], $value)) {
                    $errorMessage = array_key_exists('constraintError', $inputConfig) ? $inputConfig['constraintError'] : 'Ce champ n\'est pas valide';

                    $this->setMessages($inputName, $errorMessage);
                }

            } else {
                dd('Throw la clé n\'existe pas');
            }
        }
        if (!empty($this->getMessages())) {
            return false;
        }
        return true;
    }

    public function setMessages($key, $message): void
    {
        $this->formErrors[$key] = $message;
    }

    public function getMessages(): array
    {
        return $this->formErrors;
    }

    public function getData()
    {
        return $this->requestParams;
    }
}

