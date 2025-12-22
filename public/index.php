<?php

require_once '../paths.php';
require_once '../config.php';
require_once '../routes.php';
require_once '../router.php';

if (DEBUG_MODE) {
    require_once '../debug.php';
}

$requestedUri = $_SERVER['REQUEST_URI'];

routeRequest($requestedUri);
