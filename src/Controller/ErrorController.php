<?php

namespace App\Controller;

class ErrorController
{
    public static function error404()
    {
        echo "404";
        die;
    }
}