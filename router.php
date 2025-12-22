<?php

function routeRequest(string $uri): void
{
    global $ROUTES;

    if (array_key_exists($uri, $ROUTES)) {
        $controllerName = $ROUTES[$uri];
        loadController($controllerName);
    } else {
        loadController('404');
    }
}
