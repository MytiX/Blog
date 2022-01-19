<?php

namespace App\Core\FormSecurity;

use App\Core\FormSecurity\FormSecurityException\FormSecurityException;
use App\Core\FormSecurity\FormSecurityInterface\FormSecurityInterface;
use App\Core\Session\Session;
use Symfony\Component\HttpFoundation\Request;

abstract class FormSecurity implements FormSecurityInterface
{
    protected Request $request;

    protected Session $session;

    public array $configInput = [];

    public array $requestParams = [];

    protected string $isNullError = 'Champ obligatoire';

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
        if ('POST' === $this->request->getMethod()) {
            return true;
        }

        return false;
    }

    public function isValid()
    {
        $error = false;

        $allInput = $this->getRequestParams();

<<<<<<< HEAD
        foreach ($this->configInput as $inputName => $config) {
            $type = $config['type'];
            if (!array_key_exists($inputName, $allInput)) {
                if ('checkbox' !== $type) {
                    $error = true;
                    continue;
                }
            }
=======
        foreach ($allInput as $inputName => $value) {
            if (array_key_exists($inputName, $this->configInput)) {
                $inputConfig = $this->configInput[$inputName];

                switch ($inputConfig['type']) {
                    case 'string':
                        if (empty($value) && array_key_exists('isNull', $inputConfig) && true !== $inputConfig['isNull']) {
                            $this->setMessages($inputName, $this->isNullError);
                            $error = true;
                            break;
                        }

                        if (array_key_exists('constraint', $inputConfig) && !preg_match($inputConfig['constraint'], $value)) {
                            $errorMessage = array_key_exists('constraintError', $inputConfig) ? $inputConfig['constraintError'] : 'Ce champ n\'est pas valide';
                            $this->setMessages($inputName, $errorMessage);
                            $error = true;
                        }

                        break;
>>>>>>> 159c933 (WIP)

            $nullable = $config['nullable'];

            if ('string' === $type || 'checkbox' === $type) {

                if (false === $nullable && empty($allInput[$inputName])) {
                    if (array_key_exists('nullError', $config) && !empty($config['nullError'])) {
                        $this->setMessages($inputName, $config['nullError']);
                    } else {
                        $this->setMessages($inputName, $this->isNullError);
                    }
                    $error = true;
                    continue;
                }

                if (array_key_exists($inputName, $allInput) && !preg_match($config['constraint'], $allInput[$inputName])) {
                    $this->setMessages($inputName, $config['constraintError']);
                    $error = true;
                    continue;
                }
            }

            if ('file' === $type) {
                if (empty($class = $config['class']) || empty($function = $config['function'])) {
                    throw new FormSecurityException('Error : '.get_class($this).', the class or the function is missing on the key', 500);
                }

                if (!class_exists($class) || !method_exists($class, $function)) {
                    throw new FormSecurityException('Error : '.get_class($this).', the class or the function does not exist', 500);
                }

                $nullable = !empty($config['nullable']) ? $config['nullable'] : false;

                $class = new $class($this->request, $this->session);

                $result = call_user_func_array([$class, $function], [$inputName, $nullable]);

                if (false === $result) {
                    $error = true;
                } else {
                    $this->requestParams[$inputName] = $result;
                }
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
        return $this->getRequestParams();
    }

    public function setData(string $key, mixed $value): void
    {
        $this->requestParams[$key] = $value;
    }

    public function setConfigInput(string $nameInput, string $key, mixed $value): void
    {
        if (!array_key_exists($nameInput, $this->configInput) && !array_key_exists($key, $this->configInput[$nameInput])) {
            throw new FormSecurityException('The key of input does not exist', 500);
        }

        $this->configInput[$nameInput][$key] = $value;
    }
}
