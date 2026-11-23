<?php

session_start();

require __DIR__ . '/../src/vendor/autoload.php';

use src\app\core\Auth;
use src\app\core\Routing;

$router = new Routing();
$router->start();
