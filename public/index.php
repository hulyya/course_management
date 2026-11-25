<?php
session_start();

require __DIR__ . '/../src/vendor/autoload.php';
use Symfony\Component\HttpFoundation\Request;
use src\app\core\Routing;
// session start event. entfernen
$request = Request::createFromGlobals();

$routing = new Routing();
$response = $routing->start($request);

$response->send();