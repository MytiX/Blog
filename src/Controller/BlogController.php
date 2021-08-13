<?php

namespace App\Controller;

class BlogController 
{
    public function index(string $slug)
    {
        echo __CLASS__ . " " . $slug;
    }
}