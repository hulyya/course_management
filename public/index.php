<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

session_start();

require __DIR__ . '/../src/vendor/autoload.php';

use src\app\core\Auth;
use src\app\core\Routing;

$router = new Routing();
$router->start();
