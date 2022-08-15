<?php

require(__DIR__ . "/Environment/Enviroment.php");
require(__DIR__ . "/Environment/Connection.php");
require(__DIR__ . "/Routes.php");
require(__DIR__ . "/Controllers/BaseController.php");
require(__DIR__ . "/Repository/BaseRepository.php");

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        // may also be using PUT, PATCH, HEAD etc
        header("Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS");
    
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
}

$request = $_SERVER['REQUEST_URI'];

$request = explode("/", $request);

$calledRoute = $routes[$request[1]];

$classToLoad = $calledRoute["class"];

$filePath = __DIR__ . "/Controllers/" . $classToLoad . ".php";
if (!file_exists($filePath)) {
    throw new Exception("File does not exist: " . $filePath);
}

require($filePath);

$requestMethod = $_SERVER["REQUEST_METHOD"];

$functionToLoad = $routes[$request[1]][$requestMethod];

$params = $request[2] ?? null;

$class = new $classToLoad();

print_r(call_user_func(array($class, $functionToLoad), $params));