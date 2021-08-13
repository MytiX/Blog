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

    public function get($key = null) 
    {
        
        if ($key === null) 
        {
            return $this->get;
        }

        return $this->get[$key];
    }

    public function getRequestUri() 
    {
        return $this->server["REQUEST_URI"];
    }
    public function getHost() 
    {
        return $this->server["HTTP_HOST"];
    }
}