<?php

namespace App\Core\FormSecurity;

use App\Core\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use App\Core\FormSecurity\FormSecurityException\FormSecurityException;
use App\Core\FormSecurity\FormSecurityInterface\FormSecurityInterface;

abstract class FormSecurity implements FormSecurityInterface
{
    protected Request $request;

    protected Session $session;

    protected array $configInput = [];

    public array $requestParams = [];

    protected array $formErrors = [];

    protected string $isNullError = 'Le champs ne peux pas être vide';

    public function __construct(Request $request, Session $session)
    {
        $this->request = $request;

        $this->session = $session;

        $this->setRequestParams();
    }

    private function setRequestParams(): void
    {
        $this->requestParams = array_merge($this->request->request->all(), $this->request->files->all());
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
        $error = false;

        $allInput = $this->getRequestParams();

        foreach ($allInput as $inputName => $value) {

            if (array_key_exists($inputName, $this->configInput)) {

                $inputConfig = $this->configInput[$inputName];

                switch ($inputConfig['type']) {
                    case 'string':

                        if (empty($value) && array_key_exists('isNull', $inputConfig) && true !== $inputConfig['isNull']) {
                            $this->setMessages($inputName, $this->isNullError);
                            $error = true;
                            continue;
                        }

                        if (array_key_exists('constraint', $inputConfig) && !preg_match($inputConfig['constraint'], $value)) {
                            $errorMessage = array_key_exists('constraintError', $inputConfig) ? $inputConfig['constraintError'] : 'Ce champ n\'est pas valide';
                            $this->setMessages($inputName, $errorMessage);
                            $error = true;
                        }

                        break;

                    case 'file':
                        if (empty($class = $inputConfig['class']) || empty($function = $inputConfig['function'])) {
                            dd('Throw File');
                        }

                        if (!class_exists($class) || !method_exists($class, $function)) {
                            dd('function ou class n\'existe pas');
                        }

                        $nullable = !empty($inputConfig['params']['nullable']) ? $inputConfig['params']['nullable'] : false;

                        $class = new $class($this->request, $this->session);

                        $result = call_user_func_array([$class, $function], [$inputName, $nullable]);

                        if (false === $result) {
                            $error = true;
                        }
                        $this->requestParams[$inputName] = $result;

                        break;

                    default:
                        dd('Throw');
                        break;
                }
            } else {
                throw new FormSecurityException("Name of Input form does not exist", 500);
            }
        }

        if ($error) {
            return false;
        }
        return true;
    }

    public function setMessages($key, $message): void
    {
        $this->session->set($key, $message);
    }

    public function getData()
    {
        $data = $this->getRequestParams();

        if (null !== ($class = $this->getDataClass()) && class_exists($class)) {

            $data = new $class();

            foreach ($this->getRequestParams() as $key => $value) {
                $data->{'set'.ucfirst($key)}($value);
            }
        }

        return $data;
    }

    protected function getDataClass(): ?string
    {
        return null;
    }
}

