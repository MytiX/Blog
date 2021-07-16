<?php

namespace App\Core\HttpFoundation\Request;

class Request
{
    private $post;

    private $get;

    private $cookie;

    private $file;

    private $server;

    public function __construct() 
    {
        $this->post = $_POST;
        $this->get = $_GET;
        $this->cookie = $_COOKIE;
        $this->file = $_FILES;
        $this->server = $_SERVER;
    }

    public function get($key = null) {
        
        return $this->get[$key];
    }
}