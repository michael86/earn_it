<?php
require_once __DIR__ . '/../vendor/autoload.php';

require_once '../config/enviroment.php';
require_once '../config/database.php';

use Framework\Database;
use Framework\Router;

if (DEBUG_MODE) {
    require_once '../debug.php';
}
require_once '../paths.php';

loadConfig('database');

$db = new Database($DB_CONFIG);

$router = new Router();
$routes = require_once '../routes.php';

$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

$router->route($uri, $method);
