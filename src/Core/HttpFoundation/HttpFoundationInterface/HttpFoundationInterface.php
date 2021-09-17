<?php

namespace App\Core\HttpFoundation\HttpFoundationInterface;

use Throwable;

interface HttpFoundationInterface extends Throwable
{
    public function getStatusCode();
}