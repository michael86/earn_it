<?php

function routeRequest(string $uri): void
{
    global $ROUTES;

    if (array_key_exists($uri, $ROUTES)) {
        $viewName = $ROUTES[$uri];
        loadView($viewName);
    } else {
        loadView('404');
    }
}
