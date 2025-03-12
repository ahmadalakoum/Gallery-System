<?php

// Define your base directory 
$base_dir = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Remove the base directory from the request if present
if (strpos($request, $base_dir) === 0) {
    $request = substr($request, strlen($base_dir));
}

// Ensure the request is at least '/'
if ($request == '') {
    $request = '/';
}

$apis = [
    '/register' => ['controller' => 'UserController', 'method' => 'registerUser'],
    '/login' => ['controller' => 'UserController', 'method' => 'loginUser'],
    '/upload' => ['controller' => 'PhotoController', 'method' => 'insertPhoto'],
    '/photo' => ['controller' => 'PhotoController', 'method' => 'getPhoto'],
    '/photos' => ['controller' => 'PhotoController', 'method' => 'getPhotos'],
    '/delete' => ['controller' => 'PhotoController', 'method' => 'deletePhoto']
];

if (isset($apis[$request])) {
    $controllerName = $apis[$request]['controller'];
    $method = $apis[$request]['method'];
    require_once "apis/v1/{$controllerName}.php";

    $controller = new $controllerName();
    if (method_exists($controller, $method)) {
        $controller->$method();
    } else {
        echo "Error: Method {$method} not found in {$controllerName}.";
    }
} else {
    echo "404 Not Found";
}