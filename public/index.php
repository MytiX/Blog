<?php

// error_reporting(E_ALL);
// ini_set("display_errors", 1);

use App\Application;
use Symfony\Component\ErrorHandler\Debug;

require "../vendor/autoload.php";

Debug::enable();

$application = new Application();

$application->initialization();