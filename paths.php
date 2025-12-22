<?php

function basePath(): string
{
    return __DIR__ . '/public/';
};

function loadView(string $viewName): void
{
    $viewPath = basePath() . 'views/' . $viewName . '.php';
    if (file_exists($viewPath)) {
        require_once $viewPath;
    } else {
        require_once basePath() . 'views/404.php';
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
