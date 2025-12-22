<?php

require_once '../paths.php';
require_once '../config.php';
require_once '../router.php';

if (DEBUG_MODE) {
    require_once '../debug.php';
}

$router = new Router();
$routes = require_once '../routes.php';

$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

$router->route($uri, $method);
