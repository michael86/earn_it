<?php

require_once '../config/enviroment.php';
require_once '../config/database.php';

if (DEBUG_MODE) {
    require_once '../debug.php';
}

require_once '../paths.php';

require_once basePath('Database.php');
require_once basePath('router.php');
loadConfig('database');

$db = new Database($DB_CONFIG);

$router = new Router();
$routes = require_once '../routes.php';

$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

$router->route($uri, $method);
