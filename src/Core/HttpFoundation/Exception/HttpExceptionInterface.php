<?php

namespace App\Core\HttpFoundation\Exception;

use Throwable;

interface HttpExceptionInterface extends Throwable
{
    public function getStatusCode(): int;
}
