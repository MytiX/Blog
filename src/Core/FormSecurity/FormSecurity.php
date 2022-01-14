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
        if ('POST' === $this->request->getMethod()) {
            return true;
        }

        return false;
    }

    public function isValid()
    {
        $error = false;

        $allInput = $this->getRequestParams();

        foreach ($this->configInput as $inputName => $config) {
            if (array_key_exists($inputName, $allInput) || 'checkbox' === $config["type"]) {
                switch ($config["type"]) {
                    case 'string' || 'checkbox':
                        if (empty($allInput[$inputName]) && array_key_exists('isNull', $config) && true !== $config['isNull']) {
                            if ('checkbox' === $config['type']) {
                                $this->setMessages($inputName, $config['constraintError']);
                            } else {
                                $this->setMessages($inputName, $this->isNullError);
                            }
                            $error = true;
                            break;
                        }

                        if (array_key_exists('constraint', $config) && !preg_match($config['constraint'], $allInput[$inputName])) {
                            $errorMessage = array_key_exists('constraintError', $config) ? $config['constraintError'] : 'Ce champ n\'est pas valide';
                            $this->setMessages($inputName, $errorMessage);
                            $error = true;
                        }
                            break;
                    case 'file':
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
                        }
                        $this->requestParams[$inputName] = $result;
                            break;

                    default:
                        throw new FormSecurityException('The type is undefined', 500);
                        break;
                }
            } else {
                $error = true;
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

    public function setConfigInput(string $nameInput, string $key, mixed $value): void
    {
        if (!array_key_exists($nameInput, $this->configInput) && !array_key_exists($key, $this->configInput[$nameInput])) {
            throw new FormSecurityException('The key of input does not exist', 500);
        }

        $this->configInput[$nameInput][$key] = $value;
    }
}
