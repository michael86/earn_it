<?php

function routeRequest(string $uri): void
{
    global $ROUTES;

    if (array_key_exists($uri, $ROUTES)) {
        $viewName = $ROUTES[$uri];
        loadPage($viewName);
    } else {
        loadPage('404');
    }
}
