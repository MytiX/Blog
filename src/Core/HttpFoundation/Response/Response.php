<?php

namespace App\Core\HttpFoundation\Response;

use ReflectionClass;

class Response {

    public static function redirect($action) 
    {
        header("Location: http://localhost:8741/?action=" . $action);
        exit;
    }
}