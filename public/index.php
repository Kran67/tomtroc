<?php

require_once '../config/config.php';
require_once '../config/autoload.php';

use App\config\Autoloader;
use App\src\router\Router;

Autoloader::register();

$router = new Router();
$router->handleRequest();