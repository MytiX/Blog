<?php

namespace App\Core\Exception;

use Exception;
use Throwable;
use App\Core\HttpFoundation\HttpFoundationInterface\HttpFoundationInterface;

class CoreException extends Exception implements HttpFoundationInterface
{
    private int $statusCode;

    public function __construct(string $message, int $statusCode, $code = 0, ?Throwable $previous = null)
    {
        $this->statusCode = $statusCode;

        parent::__construct($message, $code, $previous);
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }
}
