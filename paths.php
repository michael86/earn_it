<?php

function basePath(): string
{
    return __DIR__ . '/';
};

function loadPage(string $viewPage): void
{
    $pagePath = basePath() . 'views/pages/' . $viewPage . '.php';
    if (file_exists($pagePath)) {
        require_once $pagePath;
    } else {
        require_once basePath() . 'views/pages/404.php';
    }
}

function  loadPartial(string $partialName): void
{
    $partialPath = basePath() . 'views/partials/' . $partialName . '.php';
    if (file_exists($partialPath)) {
        require_once $partialPath;
    } else {
        require_once basePath() . 'views/partials/404.php';
    }
}

function loadController(string $controllerName): void
{
    $controllerPath = basePath() . 'controllers/' . $controllerName . '.php';
    if (file_exists($controllerPath)) {
        require_once $controllerPath;
    } else {
        require_once basePath() . 'controllers/404.php';
    }
}
