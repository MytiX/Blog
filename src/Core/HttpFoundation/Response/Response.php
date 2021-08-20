<?php

namespace App\Core\HttpFoundation\Response;

use ReflectionClass;

class Response {

    public function __construct(private string $content)
    {}

    // public static function redirect($action) 
    // {
    //     header("Location: http://localhost:8741/?action=" . $action);
    //     exit;
    // }

    public function send() 
    {
        // $this->setHeader();

        echo $this->content;
    }

    private function setHeader() 
    {
        
    }
}