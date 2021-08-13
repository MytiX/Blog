<?php

namespace App\Controller;

class HomeController 
{
    public function test($slug)
    {
        echo __CLASS__ . " " . $slug;
    }
}